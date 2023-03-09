<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CourseController extends Controller
{
    public function index()
    {
        $courses_highlight = Course::where('status', Course::HIGHLIGHT )->get();
        $courses_public_course = Course::where('status', Course::HIGHLIGHT )->get();
    }

    public function show($id)
    {
        try {
            DB::beginTransaction();
            $courses = Course::find($id);
            $orders=[];
            if(auth()->user()){
                $orders = Order::where('course_id',$courses->id)->where('user_id',auth()->user()->id)->get();
            }
            if(!empty($orders)) {
                foreach ($orders as $order) {
                    if($order->status == Order::CONFIRM) {
                        return redirect()->route('home');
                    }
                }
            }
            if(count($orders) == 0) {
                return view('user.courses.detail')->with([
                    'courses' => $courses,
                ]);
            }else{
                foreach ($orders as $order) {
                    if($order->status == Order::WAIT) {
                        $order->check = false;
                    }
                }

            }
//            dd( $order->check);
            DB::commit();
            return view('user.courses.detail')->with([
                'courses' => $courses,
                'order' => $order
            ]);
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
}
