<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Staff;
use App\Models\Statistical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $orders = Order::orderBy('created_at', 'DESC')->get();
            DB::commit();
            return view('admin.orders.list')->with([
                'orders' => $orders
            ]);
        }catch (\Exception $exception) {
            DB::rollBack();
            \Log::error([
                'methor' =>  __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function  list(Request $request)
    {
        try {
            $orders = Order::
                where(function ($query) use ($request) {
                    if ($request->status != '') {
                        $query->where('status', $request->status);
                    }
                    if ($request->search != '') {
                        $query->where('order_id', 'like', "%" . $request->search . "%");
                    }
                })
                ->orderBy('created_at', 'DESC')->get();
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('action', function ($orders) {
                    if($orders->status == Order::WAIT) {
                        return '
                          <a
                             data-id="'.$orders->id.'"
                             class="menu-link px-3 text-warning confirmOrder"
                             style="cursor:pointer;"
                             tooltip="Xác nhận" flow="up"  data-token="{{csrf_token()}}">
                            <i class="fa-solid fa-circle-check"></i>
                          </a>
                           <a
                                data-id="'.$orders->id.'"
                                style="color: red; cursor:pointer;"
                                class="menu-link px-3 deleteOrder" data-token="{{csrf_token()}}"
                                tooltip="Huỷ" flow="up">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        ';
                    }
                    if($orders->status == Order::CANCEL) {
                        return '';
                    };
                })
                ->editColumn('status', function ($orders) {
                    if($orders->status == Order::CONFIRM)
                    {
                        return '<p style="color: #009ef7" ><b>'.$orders->status_text.'</b></p>';
                    }
                    if($orders->status == Order::WAIT || $orders->status == Order::CANCEL)
                    {
                        return '<p style="color: red" ><b>'.$orders->status_text.'</b></p>';
                    }
                })
                ->editColumn('update_by', function ($orders) {
                    if ($orders->staff){
                        return '<p><b>'.$orders->staff->name.'</b></p>';
                    }else {
                        return '<p><b></b></p>';
                    }
                })
                ->editColumn('user_id', function ($orders) {
                    if(!empty($orders->user))
                    {
                        return '<p><b>'.$orders->user->name.'</b></p>';
                    }
                })
                ->editColumn('course_id', function ($orders) {
                    if(!empty($orders->course)) {
                        return '
                        <p ><b>'.$orders->course->name.'</b></p>
                        ';
                    }
                })
                ->editColumn('order_id', function ($orders) {
                    if(!empty($orders->order_id)) {
                       return '<a href="#" data-url="'.route('orders.list.show',$orders->id).'"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_1" class="order_show" tooltip="Chi tiết đơn hàng" flow="up">
                                <b>' . $orders->order_id . '</b>
                                </a>';;
                    }
                })
                ->rawColumns(['action', 'status','user_id','course_id','update_by','course_id','order_id'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error("ERROR", [
                'methor' => __METHOD__,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function confirmOrder($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);
            if ($order) {
                if ($order->status == Order::STATUS['WAIT']) {
                    $order->status = Order::STATUS['SUCCESS'];
                    $order->update_by = Auth::guard('admin')->user()->id;
                    $order->save();
                    $date= $order->created_at->format('Y-m-d');
                    $data_static = Statistical::where('order_date',$date)->first();
                    if($data_static){
                        $data_static->price+=$order->total;
                        $data_static->total_order+=1;
                        $data_static->save();
                    }else{
                        $statistical = new Statistical();
                        $statistical->order_date= $order->created_at->format('Y-m-d');
                        $statistical->price=$order->total;
                        $statistical->total_order=1;
                        $statistical->save();
                    }
                    DB::commit();
                    return response()->json([
                        'success' => 'Cập nhật đơn hàng thành công',
                    ]);
                }
            } else {
                return response()->json([
                    'error' => 'Đơn hàng không tồn tại',
                    'success' => 'Record has been deleted successfully!',
                ]);
            }
            return response()->json(['error' => 'Cập nhật đơn hàng thất bại']);
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error([
                'methor' =>  __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function cancelOrder($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);
            if ($order) {
                $order->status = Order::STATUS['CANCEL'];
                $order->update_by = Auth::guard('admin')->user()->id;
                $order->save();
                $status = $order->status;
                DB::commit();
                return response()->json([
                    'success' => 'Record has been deleted successfully!',
                    'status' => 200,
                    'status_order' => $status
                ]);
            } else {
                return response()->json(['error' => 'Đơn hàng không tồn tại']);
            }
            return response()->json(['error' => 'Cập nhật đơn hàng thất bại']);
        } catch (\Exception $exception) {
            \Log::error([
                'methor' =>  __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function showOrder(Request $request,$id)
    {
        DB::beginTransaction();
        try{
            $orderDetail = OrderDetail::findOrFail($id);
            $order = Order::findOrFail($id);
            if(!empty($order->staff)) {
                $staffName = $order->staff->name;
                $check = 'block';
            }else {
                $staffName = 'Chưa được xác nhận';
                $check = 'none';
            }
            if($order->status == Order::WAIT || $order->status == Order::CANCEL) {
                $color = 'red';
            }else if($order->status == Order::CONFIRM) {
                $color = '#009ef7';
            }
            $output = '';
            $course = '';
            $output = ' <h3 class="text-center">Thông tin đơn hàng</h3>
                        <p class="text-muted">Mã đơn hàng: <span id="order_id" class="fw-bolder fs-6 text-dark">'.$order->order_id.'</span></p>
                        <p class="text-muted">Người mua: <span id="order_id" class="fw-bolder fs-6 text-dark">'.$order->user->name.'</span></p>
                        <p class="text-muted">Tên khóa học: <span id="name" class="fw-bolder fs-6 text-dark">'.$orderDetail->name.'</span></p>
                        <p class="text-muted">Danh mục: <span id="categories" class="fw-bolder fs-6 text-dark">'.$orderDetail->category->name.'</span></p>
                        <p class="text-muted">Trạng thái: <span id="categories" class="fw-bolder fs-6 " style="color:'.$color.'">'.$order->status_text.'</span></p>
                        <p class="text-muted" style="display:block;" >Nhân viện xác nhận: <span style="color: black" id="categories" class="fw-bolder fs-6">'. $staffName .'</span></p>
                        <p class="text-muted">Mô tả: <span id="address" class="fw-bolder fs-6 text-dark">'.$orderDetail->description.'</span></p>
                        <p class="text-muted">Giá: <span id="phone" class="fw-bolder fs-6 text-dark">'.number_format($orderDetail->price,0,'.',',').'vnđ</span></p>
                        <p class="text-muted">Thời gian mua: <span id="status" class="fw-bolder fs-6 text-dark">'.date("H:i | d/m/Y", strtotime($orderDetail->created_at)).'</span></p>
                        '.$course.'';
            return response()->json($output);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Có lỗi xảy ra');
            return redirect()->back();
        }
    }


}

