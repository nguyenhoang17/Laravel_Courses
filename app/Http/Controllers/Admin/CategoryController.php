<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Illuminate\Support\Facades\Cache;
use Yajra\Datatables\Datatables;


class CategoryController extends Controller
{
    //
    public  function index()
    {

        return view('admin.categories.list');
    }

    public function getlist(Request $request)
    {
        $name = $request->get('search');
        $categories = Category::where('name', 'like', "%" . $name . "%")
            ->orderBy('created_at','DESC')->get();
        return Datatables::of($categories)
            ->addIndexColumn()
            ->editColumn('name', function ($category){
                return '<a href=""><b>'.$category->name.'</b></a>';
            })
            ->editColumn('image', function ($category) {
                return '
                    <a href="" class="symbol symbol-50px">
                        <div class="symbol-label">
                            <img
                                src="'.url(Storage::url($category->image)).'"
                                alt="Emma Smith" class="w-100"
                            />
                        </div>
                    </a>
                ';
            })
            ->addColumn('action', function ($category) {
                return '
                     <a href="'.route('categories.edit', ['id' => $category->id]).'"
                       data-placement="top"
                       class="menu-link px-3" data-toggle="tooltip"
                       style="cursor:pointer;"
                       tooltip="Chỉnh sửa" 
                       flow="up"
                       class="btn btn-xs btn-primary">
                        <i class="fa-solid fa-pen-to-square text-warning"></i>
                     </a>

                     <a
                        style="cursor:pointer;"
                        data-id="'.$category->id.'" data-token="{{csrf_token()}}"
                        tooltip="Xóa" 
                        flow="up"
                        class="menu-link px-3 text-warning delete">
                        <i style="color:red" class="fa-solid fa-trash"></i>
                    </a>
                ';
            })
            ->editColumn('created_at', function ($category) {
                return '
                            <div class="badge badge-light-success">
                               '.date("H:i | d/m/Y", strtotime($category->created_at)).'
                            </div>';

            })
            ->rawColumns(['name', 'image', 'action', 'created_at'])
            ->make(true);

    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public  function store(StoreCategoryRequest $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->all();
            $category = new Category;
            $category->name = $data['name'];
            $category->description = $data['description'];
            $category->status = Category::DEFAULT;
            if($request->hasFile('avatar')){
                $disk = 'public';
                $path = $request->file('avatar')->store('avatar', $disk);
                $category->image = $path;
            }
            $category->save();
            $request->session()->flash('success','Tạo danh mục mới thành công');
            DB::commit();
            return redirect()->route('categories.list');
        } catch (\Exception $exception){
            DB::rollBack();
            \log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Tạo danh mục mới không thành công');
            return redirect()->route('categories.list');
        }
    }

    public  function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit')->with([
            'category' => $category,
        ]);
    }

    public  function update(UpdateCategoryRequest $request,$id)
    {
        DB::beginTransaction();
        try{
            $data = $request->all();
            $category = Category::findOrFail($id);
            $category->name = $data['name'];
            $category->description = $data['description'];
            if($request->hasFile('avatar')){
                $disk = 'public';
                $path = $request->file('avatar')->store('avatar', $disk);
                $category->image = $path;
            };
            $category->update();
            $request->session()->flash('success', 'Cập nhật danh mục thành công');
            DB::commit();
            return redirect()->route('categories.list');
        } catch (\Exception $exception){
            DB::rollBack();
            \log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
                'data' => $request->all()
            ]);
            $request->session()->flash('error','Cập nhật danh mục không thành công');
            return redirect()->route('categories.list');
        }
    }

    public function delete($id)
    {
        try{
            $check = Course::where('category_id', $id)->first();
            if(isset($check)){
                $check = true;
                return response()->json([
                    'error' => 'Không thể xóa',
                    'check' => $check
                ]);
            }else{
                Category::destroy($id);
                return response()->json(['success' => 'Thành công']);
            }
        } catch (\Exception $exception){
            \log::error([
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
            ]);

            session()->flash('error','Xóa danh mục không thành công');
            return redirect()->route('categories.list');
        }
    }
}

