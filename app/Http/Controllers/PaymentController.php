<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentVNPAY;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\True_;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $course = Course::where('id',$request->input('course_id'))->first();
        $vnp_TxnRef = 'VNPTF'.Carbon::now()->timestamp;
        $vnp_OrderInfo = 'Thanh toán khóa học '.$course->name.' qua ví VNPAY';
        $vnp_OrderType = 'other';
        $vnp_Amount = (int)$course->price*100;
        $vnp_Locale = 'vi';
        if($request->input('bank_code')){
            $vnp_BankCode = $request->input('bank_code');
        }
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => env('VNP_TMN_CODE'),
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => env('VNP_RETURN_URL'),
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if($request->has('payment_type')){
            if((int)$request->input('payment_type') == Order::PAYMENT['VNPAY']){
                $checkVNPAY =  $this->storePayment($inputData,Order::PAYMENT['VNPAY'],$course);
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }
                $vnp_Url = env('VNP_URL') . "?" . $query;
                if (env('VNP_HASHSECRET')) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('VNP_HASHSECRET'));
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                if (!$checkVNPAY) {
                    $request->session()->flash('error', 'Khóa học đang trong danh sách chờ xác nhận');
                    return redirect()->intended('/');
                }
                return redirect($vnp_Url);
            }else{
                $check = $this->storePayment(null,Order::PAYMENT['TRANSFER'],$course);
                if (!$check) {
                    $request->session()->flash('error', 'Khóa học đang trong danh sách chờ xác nhận');
                    return redirect()->intended('/');
                }else {
                    $request->session()->flash('success', 'Vui lòng đợi xác nhận thanh toán');
                    return redirect()->intended('/');
                }
            }
        }
    }

    public function storePayment($data = null,$type,$course){
        DB::beginTransaction();
        try {
            $orders = Order::where('course_id',$course->id)->where('user_id',Auth::user()->id)
                ->where('status',Order::WAIT)->count();
            $check = false;
            if($orders == 0) {
                $order = new Order();
                $date = Carbon::now()->toDateTimeString();
                $date = str_replace('-', '',$date);
                $date = str_replace(' ', '',$date);
                $order->user_id = Auth::user()->id;
                $order->order_id = "ZC-$course->id" .str_replace(':', '',$date);
                $order->course_id = $course->id;
                $order->total = (int) $course->price;
                $order->type_payment = $type;
                $order->status = Order::STATUS['WAIT'];
                $order->save();
                $courses = Course::findOrFail($course->id);
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->name = $courses->name;
                $orderDetail->category_id = $courses->category_id;
                $orderDetail->staff_id = $courses->staff_id;
                $orderDetail->image = $courses->image;
                $orderDetail->video = $courses->video;
                $orderDetail->type = $courses->type;
                $orderDetail->file = $courses->file;
                $orderDetail->start_time = $courses->start_time;
                $orderDetail->end_time = $courses->end_time;
                $orderDetail->description = $courses->description;
                $orderDetail->publiced_at = $courses->publiced_at;
                $orderDetail->price = $courses->price;
                $orderDetail->key = $courses->key;
                $orderDetail->save();
                if(!empty($data)){
                    $this->storePaymentVnpay($data,$order->id);
                }
                DB::commit();
                $check = true;
            }
            return $check;
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error([
                'methor' =>  __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => '',
            ]);
        }
    }

    public function storePaymentVnpay($data, $orderId) {
        DB::beginTransaction();
        try {
            $payment = new PaymentVNPAY();
            $payment->user_id = Auth::user()->id;
            $payment->order_id = $orderId;
            $payment->code = $data['vnp_TxnRef'];
            $payment->money = $data['vnp_Amount'] / 100;
            $payment->content = $data['vnp_OrderInfo'];
            $payment->status = PaymentVNPAY::STATUS['UNPAID'];
            if(!empty($data['vnp_BankCode'])){
                $payment->code_bank = $data['vnp_BankCode'];
            }
            $payment->time = null;
            $payment->save();
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error([
                'methor' =>  __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => '',
            ]);
        }
    }

    public function paymentSuccess($request){
        $inputData = array();
        $returnData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, env('VNP_HASHSECRET'));
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        if($inputData['vnp_BankCode']){
            $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        }
        $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];

        try {
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                $payment = PaymentVNPAY::where('code', $orderId)->first();
                if (isset($payment)) {
                    if ($payment->money == $vnp_Amount) {
                        if (isset($payment->status) && $payment->status == PaymentVNPAY::STATUS['UNPAID']) {
                            if ($inputData['vnp_ResponseCode'] == '00' && $inputData['vnp_TransactionStatus'] == '00') {
                                $Status = 1; // Trạng thái thanh toán thành công
                                $payment->status = PaymentVNPAY::STATUS['SUCCESS'];
                                $payment->time = $inputData['vnp_PayDate'];
                                if($vnp_BankCode){
                                    $payment->code_bank = $vnp_BankCode;
                                }
                                $payment->save();

                                $order = Order::find($payment->order_id);
                                $order->status = Order::STATUS['SUCCESS'];
                                $order->save();
                            } else {
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                            }
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    } else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        }catch (\Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //Trả lại VNPAY theo định dạng JSON
//        echo json_encode($returnData);
    }

    public function return(Request $request){
        $this->paymentSuccess($request);
        $request->session()->flash('success', 'Thanh toán thành công');
        return redirect()->intended('/purchased_courses');
    }
}
