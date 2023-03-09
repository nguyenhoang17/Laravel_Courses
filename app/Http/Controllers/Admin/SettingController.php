<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Setting\UpdateStaffRequest;
use App\Http\Requests\Admin\Setting\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;

class SettingController extends Controller
{

    public function settingsIndex($id)
    {
        DB::beginTransaction();
        try{
            $staff=Staff::findOrFail($id);
            DB::commit();
            return view('admin.component.settings')->with(['staff' => $staff]);
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Chỉnh sửa thông tin không thành công');
            return redirect()->back();
        }
    }

    public function update(UpdateStaffRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $data = $request->all();
            $staff = Staff::findOrFail($id);
            $staff->name = $data['name'];
            $staff->address = $data['address'];
            $staff->gender = $data['gender'];
            $staff->phone = $data['phone'];
            $staff->update();
            $request->session()->flash('success','Chỉnh sửa thông tin thành công');
            DB::commit();   
            return redirect()->back();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Chỉnh sửa thông tin không thành công');
            return redirect()->back();
        }
    }
    
    public function changePassword(ChangePasswordRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $data = $request->all();
            $passwordHashed = Auth::guard('admin')->user()->password;
            if(Hash::check($data['current_password'], $passwordHashed))
            {
                $staff = Staff::findOrFail($id);
                $staff->password = Hash::make($data['new_password']);
                $staff->update();
                Auth::guard('admin')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                DB::commit();
                $request->session()->flash('success','Thay đổi mật khẩu thành công, vui lòng đăng nhập lại để xác nhận');
                return redirect()->route('admin.login');
            }
            DB::commit();
            return back()->withErrors([
                'current_password' => 'Mật  khẩu không đúng, vui lòng thử lại'
            ])->withInput();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
            $request->session()->flash('error','Thay đổi mật khẩu không thành công');
            return redirect()->back();
        }
    }

}
