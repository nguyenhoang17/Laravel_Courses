<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()  {
        try {
            DB::beginTransaction();
            $courses_highlight = Course::where('is_featured', Course::STATUS_PUBLISHED )
                ->orderBy('created_at','DESC')->paginate(3);
            if(!empty(Auth::guard('web')->user()->id)) {
                $orders = Order::where('user_id', Auth::guard('web')->user()->id)
                    ->orderBy('created_at','DESC')->get();
                foreach ($courses_highlight as $course) {
                    foreach ($orders as $order) {
                        if($course->id == $order->course_id && $order->status == Order::CONFIRM ) {
                            $course['check'] =  Order::CONFIRM;
                        }
                        else if($course->id == $order->course_id && $order->status == Order::WAIT ) {
                            $course['check'] = Order::WAIT;
                        }
                    }
                }
            }
            $categories = Category::orderBy('created_at','DESC')
                ->orderBy('created_at','DESC')->get();
            foreach($categories as $category){
                $courses = Course::where('category_id',$category->id)->where('status',Course::STATUS_PUBLISHED )
                    ->orderBy('created_at','DESC')->paginate(3);
                $category->courses = $courses;
                if(!empty(Auth::guard('web')->user()->id)) {
                    $orders = Order::where('user_id', Auth::guard('web')->user()->id)
                        ->orderBy('created_at','DESC')->get();
                    foreach ($category->courses as $course) {
                        foreach ($orders as $order) {
                            if($course->id == $order->course_id && $order->status == Order::CONFIRM ) {
                                $course['check'] =  Order::CONFIRM;
                            }
                            else if($course->id == $order->course_id && $order->status == Order::WAIT ) {
                                $course['check'] = Order::WAIT;
                            }
                        }
                    }
                }
            }
            DB::commit();
            return view('user.home')->with([
                'courses_highlight' => $courses_highlight,
                'categories' => $categories,
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
