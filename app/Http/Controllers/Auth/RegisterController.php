<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Toastr;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try{
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->status = User::STATUS['UN_CONFIRM'];
            $user->address = $request->input('address');
            $user->gender = (int)$request->input('gender');
            $user->phone = $request->input('phone');
            $code = Str::random(8);
            while (User::where('code',$code)->count() > 0){
                $code = Str::random(8);
            }
            $user->code = $code;
            $user->save();
            DB::commit();
            Mail::send('admin.emails.confirm-account',compact('user'),function($email) use($user){
                $email->subject('Xác nhận đăng ký tài khoản');
                $email->to($user->email,'Xác nhận đăng ký tài khoản');
            });
            $request->session()->flash('success','Đăng ký tài khoản thành công, vui lòng kiểm tra email của bạn !');
            return redirect()->route('user.login');
        } catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
               'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Đăng ký tài khoản không thành công !');
            return redirect()->back()->withInput();
        }
    }
    public function confirm(Request $request,$code){
        DB::beginTransaction();
        try {
            $user = User::where('code',$code)->first();
            if($user && $user->status == User::STATUS['UN_CONFIRM']){
                $user->status = User::STATUS['ACTIVE'];
                $user->save();
                DB::commit();
                $request->session()->flash('success','Xác nhận email đăng ký tài khoản thành công !');
            }else{
                $request->session()->flash('error','Có lỗi xảy ra !');
            }
            return redirect()->route('user.login')->withInput();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Có lỗi xảy ra !');
            return redirect()->route('user.login')->withInput();
        }
    }
}
