<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Order;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public  function  index($id) {
        try {
            DB::beginTransaction();
            if(!empty($id)) {
                $category = Category::where('id',$id)
                    ->orderBy('created_at','DESC')->get();
                $courses = Course::where('category_id',$id)
                    ->orderBy('created_at','DESC')->get();
                if(!empty(Auth::guard('web')->user()->id)) {
                    $orders = Order::where('user_id', Auth::guard('web')->user()->id)
                        ->orderBy('created_at','DESC')->get();
                    foreach ($courses as $course) {
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
            return view('user.categories.list')->with([
                'courses' => $courses,
                'category' => $category
            ]);
        }catch (\Exception $exception) {
            DB::rollBack();
            \Log::error([
                'methor' =>  __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }
    }

    public  function searchCategory(Request  $request) {
        try {
            DB::beginTransaction();
            $name = $request->name;
            if(!empty($name)) {
                $courses = Course::where('name','LIKE',"%$name%")->orderBy('created_at','DESC')->get();
                if(!empty(Auth::guard('web')->user()->id)) {
                    $orders = Order::where('user_id', Auth::guard('web')->user()->id)
                        ->orderBy('created_at','DESC')->get();
                    foreach ($courses as $course) {
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
            }else {
                $request->session()->flash('error','Yêu cầu nhập tên để tìm kiếm');
                return redirect()->route('home');
            }
            DB::commit();
            return view('user.categories.search')->with([
                'courses' => $courses,
                'name' => $name
            ]);
        }catch (\Exception $exception) {
            DB::rollBack();
            \Log::error([
                'methor' =>  __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }
    }

    public  function searchTag(Request $request) {
        $id = $_GET['id'];
        try {
            DB::beginTransaction();
            if(!empty($id)) {
                $tagsId = Tag::where('id',$id)->orderBy('created_at','DESC')->get();
                foreach ($tagsId as $tag) {
                    $courses = $tag->courses;
                }
                if(count($tagsId) == 0) {
                    return view('user.tags.list')->with([
                        'tagsId' => $tagsId,
                    ]);
                }
                if(!empty(Auth::guard('web')->user()->id)) {
                    $orders = Order::where('user_id', Auth::guard('web')->user()->id)
                        ->orderBy('created_at','DESC')->get();
                    foreach ($courses as $course) {
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
            return view('user.tags.list')->with([
                'courses' => $courses,
                'tagsId' => $tagsId
            ]);
        }catch (\Exception $exception) {
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
