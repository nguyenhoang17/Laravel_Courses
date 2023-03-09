<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\Admin\Setting\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function settingsIndex($id)
    {
        DB::beginTransaction();
        try{
            $user=User::findOrFail($id);
            DB::commit();
            return view('user.component.settings')->with(['user' => $user]);
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
    
    public function update(UpdateUserRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $data = $request->all();
            $user = User::findOrFail($id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->gender = $data['gender'];
            $user->phone = $data['phone'];
            $user->update();
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
            $passwordHashed = Auth::guard('web')->user()->password;
            if(Hash::check($data['current_password'], $passwordHashed))
            {
                $user = User::findOrFail($id);
                $user->password = Hash::make($data['new_password']);
                $user->update();
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                DB::commit();
                $request->session()->flash('success','Thay đổi mật khẩu thành công, vui lòng đăng nhập lại để xác nhận');
                return redirect()->route('user.login');
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
