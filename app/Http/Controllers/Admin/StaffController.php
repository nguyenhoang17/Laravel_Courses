<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Staff\StoreStaffRequest;
use App\Http\Requests\Admin\Staff\UpdateStaffRequest;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.staffs.list');
    }

    public function getList(Request $request)
    {
        try{
            $staffs = Staff::where('id','!=', Auth::guard('admin')->id())
                ->where(function ($query) use ($request){
                    if ($request->role != '') {
                        $query->where('role', $request->role);
                    }
                    if ($request->search != '') {
                        $query->where('name', 'like', "%" . $request->search . "%")
                            ->orWhere('email', 'like', "%" . $request->search . "%")
                            ->orWhere('phone', 'like', "%" . $request->search . "%");
                    }
                })
                ->orderBy('created_at','DESC')->get();
            return Datatables::of($staffs)
                ->addIndexColumn()
                ->editColumn('role', function ($staff) {
                    if($staff->role == Staff::ROLE_ADMIN){
                        return 'Quản trị viên';
                    }
                    if($staff->role == Staff::ROLE_EDITOR){
                        return 'Biên tập viên';
                    }
                    if($staff->role == Staff::ROLE_TEACHER){
                        return 'Giảng viên';
                    }
                })
                ->addColumn('action', function ($staff) {
                    return '
                            <a href="'.route("staffs.edit",["id" => $staff->id]).'" class="menu-link px-3 text-warning" tooltip="Cập nhật tài khoản" flow="up">
							    <i class="fa-solid fa-pen-to-square"></i></a>
                            <a style="color: red; cursor:pointer;" class="menu-link px-3 show_confirm" data-id="'.$staff->id.'" data-token="{{csrf_token()}}" tooltip="Xoá tài khoản" flow="up">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <a style="cursor:pointer;" class="menu-link px-3 text-success reset_pass" data-id="'.$staff->id.'" data-token="{{csrf_token()}}" tooltip="Reset mật khẩu" flow="up">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                            </a>';
                })
                ->editColumn('status', function ($staff) {
                    if ($staff->status == Staff::STATUS_LOCKED){
                        return '
                            <a style="color: red; cursor:pointer;" class="menu-link px-3 lock" data-id="'.$staff->id.'" data-token="{{csrf_token()}}" tooltip="Mở khoá tài khoản" flow="up">
                                    <i class="fa-solid fa-lock text-danger"></i>
                            </a>';
                    }
                    if($staff->status == Staff::STATUS_UNLOCKED){
                        return '
                            <a style="color: red; cursor:pointer;" class="menu-link px-3 lock" data-id="'.$staff->id.'" data-token="{{csrf_token()}}" tooltip="Khoá tài khoản" flow="up">
                                <i class="fa-solid fa-unlock text-primary"></i>
                            </a>';
                    }
                })
                ->editColumn('name', function ($staff){
                    return '<a href="#" data-url="'.route('staffs.show',$staff->id).'" data-bs-toggle="modal" data-bs-target="#kt_modal_1" class="staff_show" tooltip="Thông tin nhân viên" flow="right"><b>'.$staff->name.'</b></a>';
                })
                ->rawColumns(['action', 'status', 'name'])
                ->make(true);
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
            ]);
            return abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('admin.staffs.create');
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
            ]);
            return redirect()->route('staffs.index')->with(['error' => 'Không thể truy cập']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffRequest $request)
    {
        try{
            $data = $request->all();
            $staff = new Staff();
            $staff->name = $data['name'];
            $staff->email = $data['email'];
            $staff->address = $data['address'];
            $staff->phone = $data['phone'];
            $staff->gender = $data['gender'];
            if($request->has('role')){
                $staff->role = $data['role'];
            }
            $staff->status= Staff::STATUS_UNLOCKED;
            $staff->password = Hash::make(Staff::PASSWORD_DEFAULT);
            $staff->save();
            $request->session()->flash('success', 'Tạo tài khoản nhân viên thành công');
            return redirect()->route('staffs.index');
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error', 'Tạo tài khoản nhân viên không thành công');
            return redirect()->route('staffs.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        $role = '';
        $output = '';
        $courseStaff = '';
        $courseStaffManager= '';
        foreach(Course::get() as $course){
            if($course->staff_id == $id) {
                $courseStaff .= '
                                <div id="course" class="fw-bolder fs-6 text-dark d-flex justify-content-between align-items-center row mb-2 ">
                                <div class="col-3"><img width="100%" height="100px" style="object-fit: cover;" src="' . url(Storage::url($course->image)) . '" class="img-user"></div>
                                <div class="col-9 fw-bolder text-dark text-left">' . $course->name . '</div>
                            </div>';
            }
        }
        if($courseStaff !== ''){
            $courseStaffManager .='<p class="text-muted">Khoá học đang quản lý: <span id="key" class="fw-bolder fs-6 text-dark"></span></p>
                                    <div class="staff_course_manager">
                                         '.$courseStaff.'
                                    </div>';
        }
        if(isset($staff->role)){
            $role .='<p class="text-muted">Quyền: <span id="role" class="fw-bolder fs-6 text-dark">'.$staff->role_vn.'</span></p>';
        }else{
            $role .='<p class="text-muted">Quyền: <span id="role" class="fw-bolder fs-6 text-dark">Chưa cấp quyền</span></p>';
        }
        $output = ' <h3 class="text-center">Thông tin nhân viên</h3>
                    <p class="text-muted">Tên nhân viên: <span id="name" class="fw-bolder fs-6 text-dark">'.$staff->name.'</span></p>
                    <p class="text-muted">Email: <span id="email" class="fw-bolder fs-6 text-dark">'.$staff->email.'</span></p>
                    <p class="text-muted">Địa chỉ: <span id="address" class="fw-bolder fs-6 text-dark">'.$staff->address.'</span></p>
                    <p class="text-muted">Số điện thoại: <span id="phone" class="fw-bolder fs-6 text-dark">'.$staff->phone.'</span></p>
                    <p class="text-muted">Giới tính: <span id="gender" class="fw-bolder fs-6 text-dark">'.$staff->gender_text.'</span></p>
                   '.$role.'
                    <p class="text-muted">Trạng thái: <span id="status" class="fw-bolder fs-6 text-dark">'.$staff->status_text.'</span></p>
                    '. $courseStaffManager.'';

        return response()->json($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('admin.staffs.edit')->with([
            'staff' => $staff
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, $id)
    {
        try{
            $data = $request->all();
            $staff = Staff::findOrFail($id);
            $staff->name = $data['name'];
            $staff->email = $data['email'];
            $staff->address = $data['address'];
            $staff->phone = $data['phone'];
            $staff->gender = $data['gender'];
            if($request->has('role')){
                $staff->role = $data['role'];
            }
            $staff->save();
            $request->session()->flash('success', 'Cập nhật tài khoản nhân viên thành công');
            return redirect()->route('staffs.index');
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error', 'Cập nhật tài khoản nhân viên không thành công');
            return redirect()->route('staffs.edit', $staff->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $check= Course::where('staff_id', $id)->first();
            $check1 = Order::where('update_by',$id)->first();
            if(isset($check) || isset($check1)){
                return redirect()->route('staffs.index')->with(['error','Không thể xoá nhân viên']);
            }else{
                Staff::destroy($id);
                return response()->json([
                    'success' => 'Record has been deleted successfully!',
                    'status' => 200
                ]);
            }

        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
                'data' => $id
            ]);
            return redirect()->route('staffs.index');
        }
    }

    public function lock($id)
    {
        try{
            $staff = Staff::findOrFail($id);
            if($staff->status){
                $staff->status = Staff::STATUS_UNLOCKED;
            }else{
                $staff->status = Staff::STATUS_LOCKED;
            }
            $staff->save();
            return response()->json([
                'staff_status' =>  $staff->status,
                'status' => 200,
            ]);
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
                'data' => $id
            ]);
            return redirect()->route('staffs.index');
        }
    }

    public function resetPassword($id)
    {
        try{
            $staff = Staff::findOrFail($id);
            $staff->password = Hash::make(Staff::PASSWORD_DEFAULT);
            $staff->save();
            return response()->json([
                'status' => 200,
            ]);
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
                'data' => $id
            ]);
            return redirect()->route('staffs.index');
        }
    }
}


