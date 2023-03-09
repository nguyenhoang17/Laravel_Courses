<?php

namespace App\Http\Controllers\User;

use App\Events\Chat;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat as Message;
use Illuminate\Support\Facades\Log;

class ChatsController extends Controller
{
    public function sendMessage(Request $request){
        try {
            $message = new Message();
            if(Auth::guard('admin')->user()){
                $user = Auth::guard('admin')->user();
                $message->staff_id = $user->id;
            }
            if (Auth::guard('web')->user()){
                $user = Auth::guard('web')->user();
                $message->user_id = $user->id;
            }
            event(new Chat(
                $user->name,
                $request->input('message'),
                $user->id,
                $request->input('course_id'),
            ));
            $message->message = $request->input('message');
            $message->course_id = $request->input('course_id');
            $message->save();
        }catch (\Exception $e){
            Log::error('error create message',[
                "method" => __METHOD__,
                "line"   => __LINE__,
                "message"=> $e->getMessage()
            ]);
        }
    }
}
