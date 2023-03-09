<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $course = Course::find($id);
        return view('admin.units.list')->with([
            'course' => $course
        ]);
    }

    public function getList($id)
    {
        try{
            $units = Unit::where('course_id',$id)->orderBy('index','DESC')->get();
//            Log::info($units);
            return Datatables::of($units)
                ->addIndexColumn()
                ->editColumn('index', function ($unit) {
                    return $unit->index;

                })
                ->addColumn('action', function ($unit) {
                    $actionCoursesEdit='';
                    if((Auth::guard('admin')->user()->role === 'admin' || Auth::guard('admin')->user()->role === 'editor')){
                        $actionCoursesEdit.= '<a href="'.route("units.edit",["id" => $unit->id]).'" class="menu-link px-3 text-warning" tooltip="Cập nhật bài học"  flow="up">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                           </a>
                                            <a style="color: red; cursor:pointer;" class="menu-link px-3 show_confirm" data-id="'.$unit->id.'" data-token="{{csrf_token()}}" tooltip="Xoá bài học"  flow="up">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>';
                    }
                        $actionCourses = $actionCoursesEdit;

                    return $actionCourses;


                })
                ->editColumn('index', function ($unit) {
                    return $unit->index;
                })
                ->editColumn('name', function ($unit){
                        return '<a href="#" data-url="'.route('units.show',$unit->id).'" data-bs-toggle="modal" data-bs-target="#unit_detail" class="unit_show" tooltip="Chi tiết bài học" flow="up"><b>' . $unit->name . '</b></a>';
                })

                ->editColumn('created_at', function ($unit){
                    return '
                            <div class="badge badge-light-success">
                               '.date("H:i | d/m/Y", strtotime($unit->created_at)).'
                            </div>';
                })
                ->rawColumns(['index','name', 'created_at', 'action'])
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
    public function create($id)
    {
        try{
            $course = Course::find($id);
            return view('admin.units.create')->with([
                'course'=>$course
            ]);
        }catch (\Exception $exception){
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),

            ]);
            return redirect()->route('units.index')->with(['error' => 'Không thể truy cập']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        try{
            $checkVideo = '';
            $course = Course::find($id);
            if($course->type == Course::TYPE_ONDEMAND){
                $checkVideo = 'required';
            }
            $data = $request -> all();
            if($this->validateStore($request,$checkVideo) !== true){
                return redirect()->route('units.create',['course_id'=>$id])->withErrors($this->validateStore($request,$checkVideo))->withInput();
            }else{
                $checkIndex = Unit::where('index',(int)$data['index'])->where('course_id', (int)$data['course_id'])->get();
                if(count($checkIndex) > 0){
                    $error = 'Số thứ tự đã tồn tại';
                    return redirect()->route('units.create',['course_id'=>$id])->with([
                        'error'=>$error
                    ]);
                }else{
                    $unit = new Unit();
                    if($request->hasFile('video')){
                        $disk = 'public';
                        $name = $data['video']->getClientOriginalName();
                        $path = Storage::disk($disk)->putFileAs('units/video',$data['video'],$name);
                        $unit_video = $path;
                        $unit->video = $unit_video;
                    }
                    if($request->hasFile('file')){
                        $disk = 'public';
                        $name = $data['file']->getClientOriginalName();
                        $path = Storage::disk($disk)->putFileAs('units/file',$data['file'],$name);
                        $unit_file = $path;
                        $unit->file = $unit_file;
                    }

                    $unit->course_id = $data['course_id'];
                    $unit->name = $data['name'];
                    $unit->index = $data['index'];
                    $unit->save();
                    $request->session()->flash('success', 'Tạo bài học thành công');
                    DB::commit();
                    return redirect()->route('units.index',['course_id'=>$id]);
                }
            }
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error', 'Tạo khoá học không thành công');
            return redirect()->route('units.create', ['course_id'=>$id]);
        }
    }

    public function validateStore($request, $checkVideo){
        $validator = Validator::make($request->all(), [
            'name'   => ['required','string','min:5','max: 255', 'unique:units'],
            'file' => ['required','mimes:pdf'],
            'video' => ['mimes:mp4,ogx,oga,ogv,ogg,webm',$checkVideo],
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;

    }

    public function validateUpdate($request, $id){
        $validator = Validator::make($request->all(), [
            'name'   => ['required','string','min:5','max: 255', "unique:units,name,$id"],
            'file' => ['mimes:pdf'],
            'video' => ['mimes:mp4,ogx,oga,ogv,ogg,webm'],
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = Unit::findOrFail($id);
        if(isset($unit->course_id)){
            $unit->courseName =  $unit->course->name;
        }
        if($unit->video){
            $unit->video = '
               <div class="live" style="width: 100%;padding-right: 0; height:300px; margin-bottom: 50px">
                    <p class="text-muted">Video bài học:</p>
                    <video src="'.Storage::url($unit->video).'" id="video_course" height="100%" width="100%" class="video-preview" controls="controls"></video>
                </div>
                    ';
        }
        if($unit->file){
            $unit->file = '
               <div class="live" style="width: 100%; height:300px;padding-right: 0; margin-top: 30px" >
               <p class="text-muted">Tài liệu bài học:</p>
                    <iframe src="'.Storage::url($unit->file).'#toolbar=0" id="video_course" height="100%" width="100%" class="video-preview"></iframe>
                </div>
                    ';
        }
        return response()->json(['data'=>$unit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $course = Course::findOrFail($unit->course_id);
        return view('admin.units.edit')->with([
           'unit'=>$unit,
            'course'=>$course
        ]);
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
        try{
            $unit = Unit::findOrFail($id);
            $data = $request -> all();
            if($this->validateUpdate($request,$id) !== true){
                return redirect()->route('units.edit',['id'=>$id])->withErrors($this->validateUpdate($request,$id))->withInput();
            }else{
                $checkIndex = Unit::where('index',(int)$data['index'])->where('id','<>',$id)->where('course_id', $unit->course_id)->get();
                if(count($checkIndex) > 0){
                    $error = 'Số thứ tự đã tồn tại';
                    return redirect()->route('units.edit',['id'=>$id])->with([
                        'error'=>$error
                    ]);
                }else{
                    if($request->hasFile('video')){
                        $disk = 'public';
                        $name = $data['video']->getClientOriginalName();
                        $path = Storage::disk($disk)->putFileAs('units/video',$data['video'],$name);
                        $unit_video = $path;
                        $unit->video = $unit_video;
                    }
                    if($request->hasFile('file')){
                        $disk = 'public';
                        $name = $data['file']->getClientOriginalName();
                        $path = Storage::disk($disk)->putFileAs('units/file',$data['file'],$name);
                        $unit_file = $path;
                        $unit->file = $unit_file;
                    }
                    $unit->name = $data['name'];


                    $unit->index = $data['index'];
                    $unit->save();
                    $id = $unit->course_id;
                    $request->session()->flash('success', 'Chỉnh sửa bài học thành công');
                    DB::commit();
                    return redirect()->route('units.index',['course_id'=>$id]);
                }
            }
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'staff_id' => Auth::guard('admin')->id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error', 'Sửa khoá học không thành công');
            return redirect()->route('units.edit', ['id'=>$id]);
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
        $unit=Unit::findOrFail($id);
        $unit->delete($id);
            return response()->json([
                'success' => 'Bản ghi đã được xóa thành công!',
                'status' => 200
            ]);
    }
}
