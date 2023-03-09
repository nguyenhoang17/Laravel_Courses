<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAdminRequest;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(LoginAdminRequest $request)
    {
        try{
            $staff = Staff::where('email',$request->input('email'))->first();
            if($staff && $staff->status == Staff::STATUS['DE_ACTIVE']){
                return back()->withErrors([
                    'login' => 'Tài khoản của bạn đã bị khóa'
                ])->withInput();
            }
            $email = $request->get('email');
            $password = $request->get('password');
            if (Auth::guard('admin')->attempt(array('email' => $email,'password' => $password,'status' => Staff::STATUS['ACTIVE']))) {
                $request->session()->regenerate();
                return redirect()->intended('admin/dashboard');
            }
            return back()->withErrors([
                'login' => 'Thông tin đăng nhập không chính xác'
            ])->withInput();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Có lỗi xảy ra khi đăng nhập');
            return redirect()->back();
        }
    }

    public function loginUser(LoginAdminRequest $request)
    {
        try{
            $user = User::where('email',$request->input('email'))->first();
            if($user && $user->status == User::STATUS['DE_ACTIVE']){
                return back()->withErrors([
                    'login' => 'Tài khoản của bạn đã bị khóa'
                ])->withInput();
            }elseif ($user && $user->status == User::STATUS['UN_CONFIRM']){
                return back()->withErrors([
                    'login' => 'Tài khoản của bạn chưa xác nhận email đăng ký'
                ])->withInput();
            }
            $email = $request->get('email');
            $password = $request->get('password');
            if (Auth::guard('web')->attempt(array('email' => $email,'password' => $password,'status' => User::STATUS['ACTIVE']))) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
            return back()->withErrors([
                'login' => 'Thông tin đăng nhập không chính xác'
            ])->withInput();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Có lỗi xảy ra khi đăng nhập');
            return redirect()->back()->withInput();
        }

    }
}
