<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::beginTransaction();
        try{
            DB::commit();
            return view('admin.users.list');
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::guard('admin')->id(),
            ]);
            return abort(404);
        }
    }

    public function getList(Request $request)
    {
        DB::beginTransaction();
        try{
            $users = User::where(function ($query) use ($request){
                    if ($request->status != '') {
                        $query->where('status', $request->status);
                    }
                    if ($request->search != '') {
                        $query->where('name', 'like', "%" . $request->search . "%")
                            ->orWhere('email', 'like', "%" . $request->search . "%")
                            ->orWhere('phone', 'like', "%" . $request->search . "%");
                    }
                })
                ->orderBy('created_at','DESC')->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($user) {
                    return '
                            <a style="cursor:pointer;" class="menu-link px-3 text-success reset_email" data-id="'.$user->id.'" data-token="{{csrf_token()}}" tooltip="Reset mật khẩu" flow="up">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                            </a>';

                })
                ->editColumn('status', function ($user) {
                    if ($user->status == User::STATUS_LOCKED){
                        return '
                            <a style="color: red; cursor:pointer;" class="menu-link px-3 status_check" data-id="'.$user->id.'" data-token="{{csrf_token()}}" tooltip="Mở tài khoản" flow="up">
                                <i class="fa-solid fa-lock text-danger" data-toggle="tooltip" data-placement="top" title="Mở khoá tài khoản"></i>
                            </a>';
                    }
                    if($user->status == User::STATUS_UNLOCKED){
                        return '
                            <a style="color: red; cursor:pointer;" class="menu-link px-3 status_check" data-id="'.$user->id.'" data-token="{{csrf_token()}}" tooltip="Khoá tài khoản" flow="up">
                            <i class="fa-solid fa-unlock text-primary" data-toggle="tooltip" data-placement="top" title="Khoá tài khoản"></i>
                            </a>';
                    }

                    if($user->status == User::STATUS['UN_CONFIRM']){
                        return '
                            <a style="color: #ff8400; cursor:pointer;" class="menu-link px-3 status_check" data-id="' .$user->id.'" data-token="{{csrf_token()}}" tooltip="Kích hoạt tài khoản" flow="up">
                            <i class="fa-solid fa-lock" data-toggle="tooltip" data-placement="top" title="Kích hoạt tài khoản"></i>
                            </a>';
                    }

                })
                ->editColumn('name', function ($user){
                    return '<a href="#" data-url="'.route('users.list.show',$user->id).'" style="color:#19aaf9 !important;" class="btn-show" data-bs-toggle="modal" data-bs-target="#kt_modal_1" tooltip="Thông tin khách hàng" flow="right">
                    <b>'.$user->name.'</b>
                </a>';
                })
                ->rawColumns(['action', 'status','name'])
                ->make(true);
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::guard('admin')->id(),
            ]);
            return abort(404);
        }

    }

    public function lockUser(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->all();
            $user = User::findOrFail($data['id']);
            if($user->status == User::STATUS['ACTIVE']){
                $user->status = User::STATUS_LOCKED;
            } else{
                $user->status = User::STATUS_UNLOCKED;
            }
            $user->save();
            DB::commit();
            return response()->json([
                'user_status' =>  $user->status,
                'status' => 200,
            ]);
        } catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::guard('admin')->id(),
                'data' => $request->all()
            ]);
            return response()->json([
                'user_status' => $user->status,
                'status' => 404
            ]);
        }

    }

    public function showUser(Request $request,$id)
    {

        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);
            $order_detail = OrderDetail::orderBy('created_at','DESC')->get();
            $output = '';
            $course = '';
            foreach($user->orders as $order){
                foreach($order_detail as $user_course){
                    if($order->status == Order::STATUS['SUCCESS'] && $order->id == $user_course->order_id){
                        $course .= '<div id="course" class="fw-bolder fs-6 text-dark d-flex justify-content-between align-items-center row mb-2">
                                        <div class="col-4"><img src="'.url(Storage::url($order->course->image)).'" class="img-user"></div>
                                        <div class="col-8 fw-bolder text-dark">'.$order->course->name.'</div>
                                    </div>';
                    }
                }
            }
            $output = ' <h3 class="text-center">Thông tin khách hàng</h3>
                        <p class="text-muted">Họ Tên: <span id="name" class="fw-bolder fs-6 text-dark">'.$user->name.'</span></p>
                        <p class="text-muted">Giới tính: <span id="gender" class="fw-bolder fs-6 text-dark">'.$user->gender_text.'</span></p>
                        <p class="text-muted">Email: <span id="email" class="fw-bolder fs-6 text-dark">'.$user->email.'</span></p>
                        <p class="text-muted">Địa chỉ: <span id="address" class="fw-bolder fs-6 text-dark">'.$user->address.'</span></p>
                        <p class="text-muted">Điện thoại: <span id="phone" class="fw-bolder fs-6 text-dark">'.$user->phone.'</span></p>
                        <p class="text-muted">Tình trạng tài khoản: <span id="status" class="fw-bolder fs-6 text-dark">'.$user->status_text.'</span></p>
                        <p class="text-muted">Khoá học đã mua:</p>
                        <div class="list-course">'.$course.'</div>';

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

    public function sendEmail(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->all();
            $user = User::findOrFail($data['id']);
            $password = Str::random(8);
            $user->password = $password;
            Mail::send('admin.emails.reset-password',compact('user'),function($email) use($user){
                $email->subject('Xác nhận đặt lại mật khẩu');
                $email->to($user->email,'Xác nhận đặt lại mật khẩu');
            });
            $user->password = Hash::make($password);
            $user->save();
            DB::commit();
            return response()->json([
                'success' => 'Gửi mail reset thành công',
                'status' => 200
            ]);
        } catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::guard('admin')->id(),
                'data' => $request->all()
            ]);
            return response()->json([
                'error' => 'Gửi mail reset thất bại',
                'status' => 404
            ]);
        }
    }
}
