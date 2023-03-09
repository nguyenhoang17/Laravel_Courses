<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Tag\StoreTagRequest;
use App\Http\Requests\Admin\Tag\UpdateTagRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Datatables\Datatables;

class TagController extends Controller
{
    public function index(){
        return view('admin.tags.list');
    }
    public function list(Request $request)
    {
        $name = $request->get('search');
        $tags = Tag::where('name', 'like', "%" . $name . "%")
                    ->orderBy('created_at','DESC')->get();

        return Datatables::of($tags)
            ->addIndexColumn()
            ->addColumn('action', function ($tag) {
                return '
                     <a href="'.route('tags.edit', ['id' => $tag->id]).'"
                       class="menu-link px-3"
                       style="cursor:pointer;"
                       tooltip="Chỉnh sửa" flow="up"
                       class="btn btn-xs btn-primary">
                        <i class="fa-solid fa-pen-to-square text-warning"></i>
                     </a>

                     <a
                        style="cursor:pointer;"
                        data-id="'.$tag->id.'" data-token="{{csrf_token()}}"
                        tooltip="Xoá" flow="up"
                        class="menu-link px-3 text-warning delete">
                        <i style="color:red" class="fa-solid fa-trash"></i>
                    </a>
                ';
            })
            ->editColumn('name', function ($tag) {
                return '<a href=""><b>'.$tag->name.'</b></a>';
            })
            ->editColumn('created_at', function ($tag) {
                return  '
                    <div class="badge badge-light-success">
                        '.date("H:i | d/m/Y", strtotime($tag->created_at)).'
                    </div>
                ';
            })
            ->editColumn('updated_at', function ($tag) {
                return  '
                    <div class="badge badge-light-success">
                        '.date("H:i | d/m/Y", strtotime($tag->updated_at)).'
                    </div>
                ';
            })
            ->rawColumns(['name', 'action', 'created_at', 'updated_at'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        try{
            $tag = new Tag;
            $tag->name = $request->input('name');
            $tag->save();
            session()->flash('success','Tạo thẻ mới thành công');
            return redirect()->route('tags.list');
        } catch (\Exception $exception){
            \log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('success','Tạo thẻ mới không thành công thành công');
            return redirect()->route('tags.list');
        }
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tags.edit')->with([
            'tag' => $tag,
        ]);
    }

    public function update(UpdateTagRequest $request, $id)
    {
        try{
            $tag = Tag::findOrFail($id);
            $tag->name = $request->input('name');
            $tag->update();
            $request->session()->flash('success','Chỉnh sửa thẻ thành công');
            return redirect()->route('tags.list');
        } catch (\Exception $exception){
            \log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('success','Chỉnh sửa thẻ không thành công');
            return redirect()->route('tags.list');
        }
    }

    public function destroy($id)
    {
        try{
            $check = DB::table('tag_course')->where('tag_id',$id)->first();
            if(isset($check)){
                $check = true;
                return response()->json([
                    'error' => 'Không thể xóa',
                    'check' => $check
                ]);
            }else{
                Tag::destroy($id);
                return response()->json(['success' => 'Thành công']);
            }
        } catch (\Exception $exception){
            \log::error([
                'method' => _METHOD_,
                'line' => _LINE_,
                'message' => $exception->getMessage(),
            ]);

            session()->flash('success','Chỉnh sửa thẻ không thành công');
            return redirect()->route('tags.list');
        }
    }
}
