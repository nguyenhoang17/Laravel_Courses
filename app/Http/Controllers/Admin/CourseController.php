<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Order;
use App\Models\Staff;
use App\Models\File;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as Files;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Courses\StoreCoursesRequest;
use App\Http\Requests\Admin\Courses\UpdateCoursesRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        $tags = Tag::get();
        return view('admin.courses.list')->with([
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function getList(Request $request)
    {
        try{
            $courses = Course::where(function ($query) use ($request){
                if ($request->search!= '') {
                    $query->where('name', 'like', "%" . $request->search . "%");
                }
                if ($request->category_id !='') {
                    $query->where('category_id', $request->category_id);
                }
                if ($request['status'] !='') {
                    $query->where('status', $request->status);
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
                ->addColumn('action', function ($course) {
                    $actionCourses='';
                    $actionCoursesEdit='';
                    $actionCoursesEdit1='';

                        $actionCoursesEdit.= '<a href="'.route("courses-manager.edit",["id" => $course->id]).'" class="menu-link px-3 text-warning" tooltip="C???p nh???t kho?? h???c"  flow="up">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                           </a>
                                            <a style="color: red; cursor:pointer;" class="menu-link px-3 show_confirm" data-id="'.$course->id.'" data-token="{{csrf_token()}}" tooltip="Xo?? kho?? h???c"  flow="up">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                            <a href="'.route("units.index",["course_id" => $course->id]).'" class="menu-link px-3 text-success" tooltip="Danh s??ch bu???i h???c"  flow="up">
                                                <i class="fa-solid fa-eye"></i>
                                           </a>';
                        $actionCoursesEdit1.= '
                                            <a href="'.route("units.index",["course_id" => $course->id]).'" class="menu-link px-3 text-success" tooltip="Danh s??ch bu???i h???c"  flow="up">
                                                <i class="fa-solid fa-eye"></i>
                                           </a>';

                    if (!isset($course->published_at) && (Auth::guard('admin')->user()->role === 'admin' || Auth::guard('admin')->user()->role === 'editor')){
                        $actionCourses = $actionCoursesEdit;
                    }elseif (!isset($course->published_at) && (Auth::guard('admin')->user()->role === 'teacher')){
                        $actionCourses = $actionCoursesEdit1;
                    }elseif(isset($course->published_at)){
                        $actionCourses = $actionCoursesEdit1;
                    }
                    return $actionCourses;


                })
                ->addColumn('publish_course', function ($course) {
                    if($course->status==\App\Models\Course::STATUS_PUBLISHED && (Auth::guard('admin')->user()->role === 'admin' || Auth::guard('admin')->user()->role === 'editor')){
                        return '
                                   <div id="" class="form-check form-check-solid form-switch" tooltip="T???t ph??t h??nh kho?? h???c"  flow="up">
                                    <input data-id="'.$course->id.'" data-token="{{csrf_token()}}" id="publish" style="background-color: #009EF7;margin: auto;" id="" class="delee form-check-input w-45px h-30px publish" type="checkbox" name="permission" value="{{$course->id}}" checked/>
                                    <label class="form-check-label" for="googleswitch"></label>
                                  </div>';
                    };
                    if($course->status==\App\Models\Course::STATUS_UNPUBLISHED && (Auth::guard('admin')->user()->role === 'admin' || Auth::guard('admin')->user()->role === 'editor')){
                        return '
                                <div id="" class="form-check form-check-solid form-switch " tooltip="Ph??t h??nh kho?? h???c"  flow="up">
                                    <input data-id="'.$course->id.'" data-token="{{csrf_token()}}" style="background-color: #CCCCCC ;margin: auto;" id="publish" class="delee form-check-input w-45px h-30px publish" type="checkbox" name="permission" value="{{$course->id}}"/>
                                    <label class="form-check-label" for="googleswitch"></label>
                                 </div>';
                    }
                })
                ->editColumn('price', function($course){
                    return number_format($course->price,0,'','.');
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
                        return '<a href="#" data-url="'.route('courses-manager.show',$course->id).'" data-bs-toggle="modal" data-bs-target="#kt_modal_1" class="course_show" tooltip="Chi ti???t kho?? h???c" flow="up"><i class="fa-solid fa-star text-warning"></i><b>' . $course->name . '</b></a>';
                    }
                    if($course->is_featured == Course::NO_FEATURED) {
                        return '<a href="#" data-url="'.route('courses-manager.show',$course->id).'" data-bs-toggle="modal" data-bs-target="#kt_modal_1" class="course_show" tooltip="Chi ti???t kho?? h???c" flow="up"><b>' . $course->name . '</b></a>';
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
                ->rawColumns(['action', 'image', 'name', 'is_featured', 'publish_course', 'tags', 'published_at', 'created_at'])
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $tags = Tag::get();
            $teachers = Staff::where('role', \App\Models\Staff::ROLE_TEACHER)->get();
            $categories = Category::get();
            return view('admin.courses.create')->with([
                'categories' => $categories,
                'teachers' => $teachers,
                'tags' => $tags
            ]);
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),

            ]);
            return redirect()->route('courses-manager.index')->with(['error' => 'Kh??ng th??? truy c???p']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $course_key = null;
            $course_video = null;
            $checkVideo = '';
            $checkKey = '';
            $data = $request -> all();
            if(isset($data['type'])){
                if($data['type'] == Course::TYPE_LIVE){
                    $checkKey = 'required';
                    if(isset($data['key'])){
                        $course_key = $data['key'];
                    }
                }
            }
            if($this->validateStore($request,$checkVideo,$checkKey) !== true){
                return redirect()->route('courses-manager.create')->withErrors($this->validateStore($request,$checkVideo,$checkKey))->withInput();
            }

            $course = new Course();
            if ($course_key!==null){
                $course->key = $course_key;
            }
            $course->name = $data['name'];
            $course->category_id = $data['category_id'];
            $course->staff_id = $data['staff_id'];
            $course->type = $data['type'];
            $course->description = $data['description'];
            if(!empty($data['is_featured'])){
                $course->is_featured = $data['is_featured'];
            }else{
                $course->is_featured = Course::NO_FEATURED;
            }
            $course->start_time =Carbon::createFromFormat('Y-m-d H:i', $data['start_time'])->timestamp;
            $course->end_time =Carbon::createFromFormat('Y-m-d H:i', $data['end_time'])->timestamp;
            $course->status = Course::STATUS_UNPUBLISHED;
            $course->start_live = Course::UN_START_LIVE;
            $course->price = $data['price'];
            if($request->hasFile('image')){
                $disk = 'public';
                $path = $request->file('image')->store('courses/images', $disk);
                $course->image = $path;
            }
            $course->save();
            $course->tags()->attach($request->get('tags'));
            $request->session()->flash('success', 'T???o kho?? h???c th??nh c??ng');
            DB::commit();
            return redirect()->route('courses-manager.index');
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error', 'T???o kho?? h???c kh??ng th??nh c??ng');
            return redirect()->route('courses-manager.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                                </tr>
                                 ';
                }
            }
            if($checkOrder ===1){
                $course->orderCourse .= '
                                <tr>
                                    <td colspan="3" style="text-align: center;">Kho?? h???c ch??a ???????c mua</td>
                                </tr>
                    ';
            }
            if(isset($course->staff_id)){
                $course->staffName =  $course->staff->name;
            }else{
                $course->staffName = 'Ch??a c?? gi???ng vi??n';
            }
            $course->typeText = $course->type_text;
            $course->categoryName =  $course->category->name;
            $course->statusText =  $course->status_text;
            $course->start_time =  Carbon::createFromTimestamp($course->start_time)->format("H:i | d/m/Y");
            $course->end_time =  Carbon::createFromTimestamp($course->end_time)->format("H:i | d/m/Y");
            if(isset($course->published_at)){
                $course->published_at =  date("H:i | d/m/Y", strtotime($course->published_at));
            }else{
                $course->published_at = 'Ch??a ph??t h??nh';
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tags = Tag::get();
        $teachers = Staff::where('role', \App\Models\Staff::ROLE_TEACHER)->get();
        $categories = Category::get();
        $course = Course::findOrFail($id);
        if(isset($course->published_at)){
            return back()->with('error', 'Kh??ng th??? s???a kho?? h???c');
        }else{
            return view('admin.courses.edit')->with([
                'categories' => $categories,
                'teachers' => $teachers,
                'tags' => $tags,
                'course' => $course
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try{
            $course = Course::find($id);
            if(isset($course->published_at)){
                return back()->with('error','Kh??ng th??? c???p nh???t kho?? h???c');
            }else{
                $course_key = null;
                $course_video = null;
                $checkKey='';
                $typeOrdemand= $course->type;
                $data = $request->all();
                if(!empty($data['type'])){
                    if($data['type'] == Course::TYPE_LIVE){
                        $checkKey='required';
                        if(isset($data['key'])){
                            $course_key = $data['key'];
                        }
                    }
                }
                if($this->validateUpdate($request, $id, $checkKey,$data['type'],$typeOrdemand) !== true){
                    return redirect()->route('courses-manager.edit', $id)->withErrors($this->validateUpdate($request, $id, $checkKey,$data['type']))->withInput();
                }

                if ($course_key!==null){
                    $course->key = $course_key;
                    $course->video = null;
                }
                $course->name = $data['name'];
                $course->category_id = $data['category_id'];
                $course->staff_id = $data['staff_id'];
                $course->type = $data['type'];
                $course->description = $data['description'];
                if(!empty($data['is_featured'])){
                    $course->is_featured = $data['is_featured'];
                }else{
                    $course->is_featured = Course::NO_FEATURED;
                }
                $course->start_time =(int)Carbon::createFromFormat('Y-m-d H:i', $data['start_time'])->timestamp;
                $course->end_time =Carbon::createFromFormat('Y-m-d H:i', $data['end_time'])->timestamp;
                $course->price = $data['price'];
                if($request->hasFile('image')){
                    $disk = 'public';
                    $path = $request->file('image')->store('courses/images', $disk);
                    $course->image = $path;
                }
                $course->save();
                $course->tags()->sync($request->get('tags'));
                $request->session()->flash('success', 'C???p nh???t kho?? h???c th??nh c??ng');
            }

            DB::commit();
            return redirect()->route('courses-manager.index');
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error', 'C???p nh???t kho?? h???c kh??ng th??nh c??ng');
            return redirect()->route('courses-manager.edit',$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course=Course::findOrFail($id);
        if(isset($course->published_at)){
            return back()->with('error', 'Kh??ng th??? s???a kho?? h???c');
        }else{
            $course->delete($id);
            $course->tags()->detach();
            File::where('course_id', $id)->delete();
            return response()->json([
                'success' => 'B???n ghi ???? ???????c x??a th??nh c??ng!',
                'status' => 200
            ]);
        }

    }

    public function publishCourse($id){
        $check = 0;
        $course = Course::findOrFail($id);
        if($course->status==Course::STATUS_PUBLISHED && isset($course->staff_id)){
            $course->status = Course::STATUS_UNPUBLISHED;
            $course->published_at = null;
            $course->save();
            return response()->json([
                'staff_status' =>  $course->status,
                'status' => 200,
            ]);
        }
        if(empty($course->staff_id)){
            $check=1;
            return response()->json([
                'check_publish' =>  $check,
                'status' => 200,
            ]);
        }
        if(Carbon::now()->timestamp < $course->start_time){
            if($course->status==Course::STATUS_UNPUBLISHED && isset($course->staff_id)){
                $course->status = Course::STATUS_PUBLISHED;
                $course->published_at = Carbon::now();
            }
            $course->save();
            return response()->json([
                'staff_status' =>  $course->status,
                'status' => 200,
            ]);
        }else{
            $check=0;
            return response()->json([
                'check_publish' =>  $check,
                'status' => 200,
            ]);
        }
    }

    public function validateStore($request, $checkVideo, $checkKey){
        $validator = Validator::make($request->all(), [
            'name'   => ['required','string','min:5','max: 255'],
            'category_id' => ['required'],
            'image' => ['required', 'mimes:jpeg,jpg,png,gif'],
            'type' => ['required'],
            'start_time' => 'required|after:' . Carbon::now(),
            'end_time' => ['required', 'after:start_time'],
            'price' => ['required', 'numeric'],
            'tags' => ['required'],
            'key' => [$checkKey],
        ], $messages = [
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;

    }

    public function validateUpdate($request, $id, $checkKey,$type, $typeOrdemand=null){
        $validator = Validator::make($request->all(), [
            'name'   => ['required','string','min:5','max: 255'],
            'category_id' => ['required'],
            'image' => ['mimes:jpeg,jpg,png,gif'],
            'type' => ['required'],
            'start_time' => 'required|after:' . Carbon::now(),
            'end_time' => ['required', 'after:start_time'],
            'price' => ['required', 'numeric'],
            'tags' => ['required'],
            'key' => [$checkKey]
        ], $messages = [
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }
}
