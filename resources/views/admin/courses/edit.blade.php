@extends('admin.layouts.master')
@section('css')
    <link href="/admin/dist/assets/css/courses/edit.css" rel="stylesheet"/>
    <link href="/admin/dist/assets/css/courses/fontanwesome.css" rel="stylesheet"/>
@endsection
@section('title')
    Danh sách khóa học
@endsection
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <form id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row row" action="{{route('courses-manager.update',['id'=> $course->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="put">
            <!--begin::Aside column-->
            <!--end::Aside column-->
            <!--begin::Main column-->
            <div style="width:100%; display:block" class="col-12">
                <!--begin::General options-->
                <div class="card card-flush py-4 row mb-10">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Khoá học</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0 row">
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="form-label">Tên khoá học</label><span style="color: red;"> *</span>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control mb-2" placeholder="Nhập tên khoá học..." value="@if(!empty(old("name"))){{old("name")}}@else {{$course->name}}@endif" />
                            @error('name')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                            <!--end::Input-->
                            <!--begin::Description-->
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->

                        <div class="mb-10 col-6" style="display:inline-block">
                            <!--begin::Label-->
                            <label class="form-label">Danh mục</label><span style="color: red;"> *</span>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <select class="form-select mb-2" name="category_id" id="cars">
                                @foreach($categories as $item)
                                        @php
                                            $selected="";
                                            if($course->category_id == $item->id){
                                              $selected = "selected";
                                            }
                                        @endphp
                                    <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror

                            <!--end::Editor-->
                            <!--begin::Description-->
                            <!--end::Description-->
                        </div>

                        <div class="mb-10 col-6" style="display:inline-block">
                            <!--begin::Label-->
                            <label class="form-label">Giảng viên</label>
                            <select class="form-select mb-2" name="staff_id" id="cars">
                                <option value="">--Chọn giảng viên--</option>
                                @foreach($teachers as $teacher)
                                    @php
                                        $selected="";
                                        if($course->staff_id == $teacher->id){
                                          $selected = "selected";
                                        }
                                    @endphp
                                    <option value="{{$teacher->id}}" {{$selected}}>{{$teacher->name}}</option>
                                @endforeach
                            </select>
                            @error('staff_id')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                        </div>

{{--                        <div class="mb-10 col-6" style="display:inline-block">--}}
{{--                            <label class="form-label">Tài liệu khoá học</label>--}}
{{--                            <input value="{{$course->files}}" type="file" name="files[]" class="form-control mb-5" placeholder="Chọn tài liệu cho khoá học..." multiple/>--}}
{{--                            @error('files.*')--}}
{{--                            <div style="color: red;" class="">{{$message}}</div>--}}
{{--                            @enderror--}}
{{--                            @error('files')--}}
{{--                            <div style="color: red;" class="">{{$message}}</div>--}}
{{--                            @enderror--}}
{{--                            <div class="mb-10">--}}
{{--                                <label class="form-label">Tài liệu đã có</label>--}}
{{--                                <div>--}}
{{--                                    <table>--}}
{{--                                        <thead>--}}
{{--                                            <tr>--}}
{{--                                                <th>Tên file</th>--}}
{{--                                                <th class="px-2">Download file</th>--}}
{{--                                                <th>Chọn file cần xoá</th>--}}
{{--                                            </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}
{{--                                        @if(!empty($course->files))--}}
{{--                                            @foreach($course->files as $file)--}}
{{--                                                <tr>--}}
{{--                                                    <td>{{$file->name}}</td>--}}
{{--                                                    <td style="text-align: center;"><a href="{{route('courses-manager.download.file', $file->id)}}"><i class="fa-solid fa-download"></i></a></td>--}}
{{--                                                    <td style="text-align: center;"><input name="delete_file[]" type="checkbox" value="{{$file->id}}"></td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                        </tbody>--}}

{{--                                    </table>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="mb-10 col-6" style="display:inline-block">
                            <label class="form-label">Chọn tag</label><span style="color: red;"> *</span>
                            <select name="tags[]" class="form-select form-select-solid" data-control="select2" data-placeholder="Chọn Tag cho khoá học" data-allow-clear="true" multiple="multiple">
                                <option></option>
                                @foreach($tags as $item)
                                    @foreach($course->tags as $course_tag)
                                        @php
                                            $selected="";
                                            if($course_tag-> id == $item->id){
                                              $selected = "selected";
                                              break;
                                            }
                                        @endphp
                                    @endforeach
                                    <option value="{{$item-> id}}" {{$selected}}>{{$item -> name}}</option>
                                @endforeach
                            </select>
                            @error('tags')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                        </div>
                        <!--Chọn loại khoá học-->

                        <div class="mb-10 col-6" style="display:inline-block">
                            <!--begin::Label-->
                            <label class="form-label">Loại khoá học</label><span style="color: red;"> *</span>
                            <select class="form-select mb-2" name="type" id="type_course">
                                <option value="">--Chọn loại khoá học--</option>
                                @foreach (\App\Models\Course::$typeCourses as $item)
                                    @if(old('type'))
                                        <option {{old('type')==$item ? "selected" : ""}} value="{{$item}}" >
                                            @if($item==App\Models\Course::TYPE_ONDEMAND) Khoá học xem video
                                            @elseif($item==App\Models\Course::TYPE_LIVE) Khoá học qua skype
                                            @endif
                                        </option>
                                    @else
                                        <option {{($course->type == $item) ? 'selected' : ''}} value="{{$item}}">
                                            @if($item==App\Models\Course::TYPE_ONDEMAND) Khoá học xem video
                                            @elseif($item==App\Models\Course::TYPE_LIVE) Khoá học qua skype
                                            @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('type')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label class="form-label">Giá tiền</label><span style="color: red;"> *</span>
                            <input type="text" name="price" class="form-control mb-2" placeholder="Nhập giá tiền..." value="@if(!empty(old("price"))){{old("price")}}@else {{$course->price}}@endif" />
                            @error('price')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                        </div>

                        {{-- key --}}
                        <div id="option__live" class="mb-10 col-6 key_live">
                            <label class="form-label">Link phòng học qua skype</label><span style="color: red;"> *</span>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="key" class="form-control mb-2" placeholder="Nhập key cho khoá học..." value="@if(!empty(old("key"))){{old("key")}}@else{{$course->key}}@endif" />
                            @error('key')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                        </div>


                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="form-label">Mô tả</label>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <textarea class="form-control mb-2" style="width:100%;" name="description" id="" rows="4" placeholder="Nhập mô tả..." >@if(!empty(old("description"))){{old("description")}}@else{{$course->description}}@endif</textarea>
                            <!--end::Editor-->
                            <!--begin::Description-->
                            <!--end::Description-->
                        </div>
                        <div class="mb-10 col-6">
                            <div class="mb-10 col-12">
                                <label class="form-label">Thời gian bắt đầu </label><span style="color: red;"> *</span>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <input name="start_time" class="form-control form-control-solid" placeholder="Chọn thời gian bắt đầu khoá học" id="kt_datepicker_3" value="@if(!empty(old("start_time"))){{old("start_time")}}@else {{date("Y-m-d H:i", $course->start_time)}}@endif"/>
                                @error('start_time')
                                <div style="color: red;" class="">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-10 col-6">
                            <div class="mb-10 col-12">
                                <label class="form-label">Thời gian kết thúc </label><span style="color: red;"> *</span>
                                <!--end::Label-->
                                <!--begin::Input-->

                                <input name="end_time" class="form-control form-control-solid" placeholder="Chọn thời gian kết thúc khoá học" id="kt_datepicker_4" value="@if(!empty(old("end_time"))){{old("end_time")}}@else {{date("Y-m-d H:i", $course->end_time)}}@endif"/>
                                @error('end_time')
                                <div style="color: red;" class="">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-10 col-12" style="display:inline-block">
                            <p>Khoá học nổi bật</p>
                            <div style="" id="check_featured" class="form-check form-check-solid form-switch">
                                <input name="is_featured" value="{{$course->is_featured}}" id="featured" class="delee form-check-input w-55px h-30px" type="checkbox"/>
                                <label class="form-check-label" for="googleswitch"></label>
                                <style>
                                    #featured{
                                        background-color: #ccc;
                                    }
                                </style>
                            </div>
                        </div>

{{--                        <div id="video__course" class="col-6 key_live">--}}
{{--                            <div class="card card-flush py-4">--}}
{{--                                <!--begin::Card header-->--}}
{{--                                <div class="card-header">--}}
{{--                                    <!--begin::Card title-->--}}
{{--                                    <div class="card-title">--}}
{{--                                        <p>Video</p><span style="color: red;"> *</span>--}}
{{--                                    </div>--}}
{{--                                    <!--end::Card title-->--}}
{{--                                </div>--}}
{{--                                <!--end::Card header-->--}}
{{--                                <!--begin::Card body-->--}}
{{--                                <div class="card-body text-center pt-0">--}}
{{--                                    <!--begin::Image input-->--}}
{{--                                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(admin/dist/media/svg/files/blank-image.svg)">--}}
{{--                                        <!--begin::Preview existing avatar-->--}}
{{--                                        <div style="display: inline-block; border: 3px solid #fff; box-shadow: 0 0.1rem 1rem 0.25rem rgb(0 0 0 / 5%);" class="video-prev ">--}}
{{--                                            <video src="{{url(\Illuminate\Support\Facades\Storage::url($course->video))}}" id="video_course" height="500" width="500" class="video-preview" controls="controls">--}}
{{--                                        </div>--}}
{{--                                        <!--end::Preview existing avatar-->--}}
{{--                                        <!--begin::Label-->--}}
{{--                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Thay đổi video">--}}
{{--                                            <!--begin::Icon-->--}}
{{--                                            <i class="bi bi-pencil-fill fs-7"></i>--}}
{{--                                            <!--end::Icon-->--}}
{{--                                            <!--begin::Inputs-->--}}
{{--                                            <input class="upload-video-file" type="file" name="video" accept=".flv, .mp4, .m3u8, .ts, .3gp, .mov, .avi, .wmv" value="{{$course->video}}"/>--}}
{{--                                            <input type="hidden" name="video_remove" id=""/>--}}
{{--                                            <!--end::Inputs-->--}}
{{--                                        </label>--}}
{{--                                        <!--end::Label-->--}}
{{--                                        <!--begin::Cancel-->--}}
{{--                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="xoá video">--}}
{{--										<i class="bi bi-x fs-2" id="remove_video"></i>--}}
{{--									</span>--}}
{{--                                        <!--end::Cancel-->--}}
{{--                                        <!--begin::Remove-->--}}
{{--                                        --}}{{-- <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">--}}
{{--                                            <i class="bi bi-x fs-2"></i>--}}
{{--                                        </span> --}}
{{--                                        <!--end::Remove-->--}}
{{--                                        @error('video')--}}
{{--                                        <div style="color: red;" class="">{{$message}}</div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                    <!--end::Image input-->--}}
{{--                                    <!--begin::Description-->--}}
{{--                                    <div class="text-muted fs-7">Thêm video cho khoá học. Chỉ các tệp video *.flv, *.mp4, *.m3u8, *.ts, *.3gp, *.mov, *.avi và *.wmv được chấp nhận</div>--}}
{{--                                    <!--end::Description-->--}}
{{--                                </div>--}}
{{--                                <!--end::Card body-->--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-6">
                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <p>Ảnh</p><span style="color: red;"> *</span>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body text-center pt-0">
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(/storage/{{$course->image}})">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-500px h-500px"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Thay đổi ảnh">
                                            <!--begin::Icon-->
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <!--end::Icon-->
                                            <!--begin::Inputs-->
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" value="{{$course->image}}"/>
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Cancel-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
										<i class="bi bi-x fs-2"></i>
									</span>
                                        <!--end::Cancel-->
                                        <!--begin::Remove-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Xoá ảnh">
										<i class="bi bi-x fs-2"></i>
									</span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->
                                    <!--begin::Description-->
                                    @error('image')
                                    <div style="color: red;" class="">{{$message}}</div>
                                    @enderror
                                    <div class="text-muted fs-7">Thêm hình ảnh minh hoạ cho khoá học. Chỉ các tệp hình ảnh *.png, *.jpg và *.jpeg được chấp nhận</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Card body-->
                            </div>
                        </div>

                        <!--end::Input group-->
                    </div>
                    <!--end::Card header-->
                </div>
                <!--end::General options-->
                <!--begin::Meta options-->
                <!--end::Meta options-->
                <!--begin::Automation-->

                <!--end::Automation-->
                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <a href="{{route('courses-manager.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Huỷ</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                        <span class="indicator-label">Lưu</span>
                        <span class="indicator-progress">Please wait...
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>

            <!--end::Main column-->
        </form>
    </div>
    <input id="type_live" type="hidden" value="{{App\Models\Course::TYPE_LIVE}}">
    <input id="type_ondemand" type="hidden" value="{{App\Models\Course::TYPE_ONDEMAND}}">
    <input id="featured_course" type="hidden" value="{{App\Models\Course::FEATURED}}">
    <input id="no_featured_course" type="hidden" value="{{App\Models\Course::NO_FEATURED}}">


@endsection
@section('js')
<script src="/admin/dist/assets/js/courses/edit.js"></script>
<script src="/admin/dist/assets/js/courses/fontanwesome.js"></script>
<script src="/admin/dist/assets/js/courses/sweetalert.js"></script>
@endsection
