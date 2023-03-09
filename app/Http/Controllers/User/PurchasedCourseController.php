<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chat as Message;
use App\Models\File;
use App\Models\OrderDetail;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Array_;

class PurchasedCourseController extends Controller
{
    public function index(Request $request)
    {
        DB::beginTransaction();
        try{
            $tags = Tag::orderBy('created_at','DESC')->get();
            $categories = Category::orderBy('created_at','DESC')->get();
            $order_detail = OrderDetail::orderBy('created_at','DESC')->get();
            $data = array('tags' => $tags,
                    'categories' => $categories,
                    'order_detail' => $order_detail);
            DB::commit();
            return view('user.purchased_courses.list')->with($data);
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);
        }
    }

    public function liveSearch(Request $request)
    {
        DB::beginTransaction();
        try{
            $order_detail = OrderDetail::orderBy('created_at','DESC')->get();
            $output = '';
            $count = 0;
            if (!empty($request->name)){
                $order_detail = OrderDetail::where('name', 'like', '%'.$request->name.'%')->orderBy('created_at','DESC')->get();
            }
            if (!empty($request->category)){
                $order_detail = OrderDetail::where('category_id',$request->category)->orderBy('created_at','DESC')->get();
            }
            if (!empty($request->name) && !empty($request->category)){
                $order_detail = OrderDetail::where('category_id',$request->category)
                                            ->where('name', 'like', '%'.$request->name.'%')
                                            ->orderBy('created_at','DESC')->get();
            }
            foreach ($order_detail as $my_course){
                if($my_course->order->status == Order::STATUS['SUCCESS'] && $my_course->order->status !== \App\Models\Order::CANCEL && $my_course->order->status !== \App\Models\Order::WAIT &&  $my_course->order->user_id == Auth::guard('web')->user()->id){
                    $type = '';
                    $start_time = '';
                    $count++;
                    if($my_course->type == \App\Models\OrderDetail::TYPE_LIVE){
                        $type = 'bg-danger';
                        $start_time = 'Bắt đầu lúc '.date("H:i | d/m/Y",$my_course->start_time).'';
                    }
                    else{
                        $start_time = 'Video và học liệu';
                    }
                    $output .= '<div class="col-lg-4 col-md-6 grid-item cat2 cat3">
                                    <div class="z-gallery mb-30">
                                        <div class="z-gallery__thumb mb-20">
                                            <a href="'.route('purchased_courses.get-course',['id' => $my_course->order->course_id]).'"><img class="img-fluid img-course" src="'.url(Storage::url($my_course->image)).'" alt=""></a>
                                            <div class="feedback-tag '.$type.'">'.$my_course->type_view.'</div>
                                        </div>
                                        <div class="z-gallery__content">
                                            <h4 class="sub-title course-name"><a href="'.route('purchased_courses.get-course',['id' => $my_course->order->course_id]).'">'.$my_course->name.'</a></h4>
                                            <div class="course__meta">
                                                <h5>
                                                    <b style="color: rgb(84,205,236);font-size: 20px;" class="sub-title">GV: '.$my_course->staff->name.'</b>
                                                </h5>
                                                <span>'.$start_time.'</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                }
            }
            if($count == 0){
                $output = '<h3 class="mb-25 text-center text-muted">Không tìm thấy khoá học</h3>';
            }
            DB::commit();
            return response()->json($output);
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);
        }
    }

    public function getCourse($id){
        try {
            $messages = [];
            $status_course = Course::findOrFail($id);
            $course = OrderDetail::query()
                ->whereHas('order', function ($query) use ($id){
                $query->where('course_id',$id)
                      ->where('user_id', Auth::guard('web')->id());
            })->with('staff')->with('order')->first();


            return view('user.purchased_courses.course-detail',[
                'messages'      => $messages,
                'course'        => $course,
                'files'         => [],
                'status_course' => $status_course
            ]);
        }catch (\Exception $e){
            Log::error('error get detail course',[
                "method" => __METHOD__,
                "line"   => __LINE__,
                "message"=> $e->getMessage()
            ]);
        }
    }

    public function getChats($course_id){
        try {
            $messages = Message::query()
                ->with('user')
                ->with('staff')
                ->where('course_id',$course_id)
                ->get();
            return $messages;
        }catch (\Exception $e){
            Log::error('error get list message',[
                "method" => __METHOD__,
                "line"   => __LINE__,
                "message"=> $e->getMessage()
            ]);
        }
    }

    public function unit($course_id,$id){
        try {
            log::info($course_id.'--'.$id);
            $unit = [];
            $messages = [];
            $status_course = Course::findOrFail($course_id);
            $unit = Unit::findOrFail($id);

            info($unit);


            return view('user.purchased_courses.unit',[
                'messages'      => $messages,
                'course'        => [],
                'files'         => [],
                'status_course' => $status_course,
                'unit'=>$unit
            ]);
        }catch (\Exception $e){
            Log::error('error get detail course',[
                "method" => __METHOD__,
                "line"   => __LINE__,
                "message"=> $e->getMessage()
            ]);
        }
    }
}
