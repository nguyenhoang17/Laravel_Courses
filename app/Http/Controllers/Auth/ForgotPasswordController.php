<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\SendEmailRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;

class ForgotPasswordController extends Controller
{
    public function postEmail(SendEmailRequest $request)
    {
        DB::beginTransaction();
        try{
            $token = Str::random(64);
            DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
            );
            Mail::send('user.emails.confirm',['token' => $token],function($message) use($request){
                $message->subject('Xác nhận đổi mật khẩu');
                $message->to($request->email,'Xác nhận đổi mật khẩu');
            });
            DB::commit();
            $request->session()->flash('success','Gửi yêu cầu thành công , vui lòng kiểm tra email để xác nhận');
            return redirect('/login');
        } catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
               'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Đã có lỗi xảy ra, vui lòng thử lại sau');
            return redirect()->back()->withInput();
        }
    }

    public function getPassword($token) { 
        DB::beginTransaction();
        try{
            $email = DB::table('password_resets')->where('token',$token)->first();
            if (!$email){
                return view('errors.mail');
            }
            DB::commit();
            return view('user.auth.reset', ['token' => $token])->with(['email' => $email]);
        } catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
               'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'data' => $request->all()
            ]);
            return view('errors.404');
        }
    }

    public function updatePassword(ChangePasswordRequest $request)
    { 
        DB::beginTransaction();
        try{
            $updatePassword = DB::table('password_resets')
                            ->where('email', $request->email)
                            ->where('token', $request->token)
                            ->first(); 
            if(!$updatePassword){
                $request->session()->flash('success','Yêu đã hết hạn, Vui lòng gửi lại yêu cầu mới');
                return back()->withInput();
            }
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            DB::table('password_resets')->where('email', $request->email)->delete();
            DB::commit();
            $request->session()->flash('success','Thay đổi mật khẩu thành công');
            return redirect('/login');
        } catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
               'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Đã có lỗi xảy ra, vui lòng thử lại sau');
            return redirect()->back()->withInput();
        }
    }
}
