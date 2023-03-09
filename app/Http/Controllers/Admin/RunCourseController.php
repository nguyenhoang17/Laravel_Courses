<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class RunCourseController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $tags = Tag::get();
        return view('admin.runcourses.list')->with([
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function getList(Request $request)
    {
        try{
            $courses = Course::where('type', Course::TYPE_LIVE)->where('status',  Course::STATUS_PUBLISHED)->where(function ($query) use ($request){
                if ($request->search!= '') {
                    $query->where('name', 'like', "%" . $request->search . "%");
                }
                if ($request->category_id !='') {
                    $query->where('category_id', $request->category_id);
                }
                if ($request['tags'] !="") {
                    $query->whereHas('tags', function ($query2) use ($request) {
                        $query2->where('tag_id', $request['tags']);
                    });
                }
            })
                ->orderBy('created_at','DESC')->get();

            return Datatables::of($courses)
                ->addIndexColumn()
                ->editColumn('image', function ($course) {
                    return'<img width="100px" height="50px" src="'.url(Storage::url($course->image)).'" alt="">';

                })
                ->editColumn('start_live', function ($course){
                    if($course->start_live==\App\Models\Course::START_LIVE && $course->type==Course::TYPE_LIVE){
                        return '
                                   <div id="" class="form-check form-check-solid form-switch" tooltip="Tắt livestream" flow="up">
                                    <input data-id="'.$course->id.'" data-token="{{csrf_token()}}" id="start_live" style="background-color: #009EF7;margin: auto;" id="" class="delee form-check-input w-45px h-30px start_live" type="checkbox" name="permission" value="{{$course->id}}" checked/>
                                    <label class="form-check-label" for="googleswitch"></label>
                                  </div>';
                    };
                    if($course->start_live==\App\Models\Course::UN_START_LIVE && $course->type==Course::TYPE_LIVE){
                        return '
                                <div id="" class="form-check form-check-solid form-switch" tooltip="Bật livestream" flow="up">
                                    <input data-id="'.$course->id.'" data-token="{{csrf_token()}}" style="background-color: #CCCCCC ;margin: auto;" id="start_live" class="delee form-check-input w-45px h-30px start_live" type="checkbox" name="permission" value="{{$course->id}}"/>
                                    <label class="form-check-label" for="googleswitch"></label>
                                 </div>';
                    }
                })
                ->editColumn('type', function ($course) {
                    return $course->type_text;
                })
                ->editColumn('staff_id', function ($course) {
                    if(!empty($course->staff_id)){
                        return $course->staff->name;
                    }
                })
                ->editColumn('name', function ($course){
                    if($course->is_featured == Course::FEATURED) {
                        return '<a href="#" data-url="'.route('courses-manager.show',$course->id).'" data-bs-toggle="modal" data-bs-target="#kt_modal_1" class="course_show"><i class="fa-solid fa-star text-warning"></i><b>' . $course->name . '</b></a>';
                    }
                    if($course->is_featured == Course::NO_FEATURED) {
                        return '<a href="#" data-url="'.route('courses-manager.show',$course->id).'" data-bs-toggle="modal" data-bs-target="#kt_modal_1" class="course_show"><b>' . $course->name . '</b></a>';
                    }
                })

                ->editColumn('created_at', function ($course){
                    return '
                            <div class="badge badge-light-success">
                               '.date("H:i | d/m/Y", strtotime($course->created_at)).'
                            </div>';
                })
                ->editColumn('published_at', function ($course){
                    if(isset($course->published_at)){
                        return '
                            <div class="badge badge-light-success">
                               '.date("H:i | d/m/Y", strtotime($course->published_at)).'
                            </div>';
                    }
                })
                ->rawColumns(['image', 'name', 'start_live', 'published_at', 'created_at'])
                ->make(true);
        }catch (\Exception $exception){
            Log::info('error get list course',[
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
            ]);
            return abort(404);
        }

    }

    public function startLive($id){
        $course = Course::findOrFail($id);
        $now = Carbon::now()->timestamp;
        $this->deleteChats($id);
        if($course->start_live==Course::UN_START_LIVE && $course->type == Course::TYPE_LIVE && isset($course->published_at)){
            if ($course->start_time>$now){
                return response()->json([
                    'error' =>  "Không thể bật live khi chưa đến thời gian bắt đầu",
                    'status' => 400,
                ]);
            }else{
                $course->start_live = Course::START_LIVE;
                $course->save();
                $this->changeStatusLive(OrderDetail::STATUS['WAITING_LIVE'], OrderDetail::STATUS['LIVING'], $id);
                return response()->json([
                    'course_status' =>  $course->start_live,
                    'status' => 200,
                ]);
            }
        }elseif($course->start_live==Course::START_LIVE){
            $course->start_live = Course::UN_START_LIVE;
            $course->save();
            $this->changeStatusLive(OrderDetail::STATUS['LIVING'], OrderDetail::STATUS['LIVED'], $id);
            $check = 1;
            return response()->json([
                'course_status' =>  $course->start_live,
                'status' => 200,
                'check_start' => $check,
            ]);
        }else{
            $course->start_live = Course::UN_START_LIVE;
            $course->save();
            return response()->json([
                'course_status' =>  $course->start_live,
                'status' => 200,
            ]);
        }
    }

    public function deleteChats($course_id){
        try {
            $chat_ids = Chat::where('course_id', $course_id)->get()->pluck('id');
            Chat::whereIn('id', $chat_ids)->delete();

        } catch (\Exception $e) {
            Log::error('Error delete old message', [
                'method' => __METHOD__,
                "line"   => __LINE__,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function changeStatusLive($status, $status_new, $id){
        try {
            $course_details = OrderDetail::query()
                ->whereHas('order', function ($query) use ($id, $status, $status_new){
                    $query->where('course_id',$id);
                })
                ->where('is_live',$status)->get();
            foreach ($course_details as $course_detail){
                $course_detail->is_live = $status_new;
                $course_detail->save();
            }
        } catch (\Exception $e) {
            Log::error('Error change status order detail', [
                'method' => __METHOD__,
                "line"   => __LINE__,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        try{
            $course = Course::findOrFail($id);
            $checkOrder= 1;
            foreach (Order::get() as $order){
                if($order->course_id == $id){
                    $checkOrder = 0;
                    $course->orderCourse .= '
                                <tr>
                                    <td>'.$order->order_id.'</td>
                                    <td>'.$order->user->name.'</td>
                                      <td>'.date("H:i | d/m/Y", strtotime($order->created_at)).'</td>
                                </tr>';
                }
            }
            if($checkOrder ===1){
                $course->orderCourse .= '
                                <tr>
                                    <td colspan="3" style="text-align: center;">Khoá học chưa được mua</td>
                                </tr>
                    ';
            }
            $course->typeText = $course->type_text;
            $course->categoryName =  $course->category->name;
            $course->staffName =  $course->staff->name;
            $course->statusText =  $course->status_text;
            $course->start_time =  Carbon::createFromTimestamp($course->start_time)->format("H:i | d/m/Y");
            $course->end_time =  Carbon::createFromTimestamp($course->end_time)->format("H:i | d/m/Y");
            if(isset($course->published_at)){
                $course->published_at =  date("H:i | d/m/Y", strtotime($course->published_at));
            }else{
                $course->published_at = 'Chưa phát hành';
            }
            foreach ($course->tags as $tag){
                $course->tagView.='<span style="margin:0 2px; " class="badge badge-info">'.$tag->name.'</span>';
            }
            $course->price =  number_format($course->price,0,'','.');
            return response()->json(['data'=>$course]);
        } catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return redirect()->back();
        }
    }
}
