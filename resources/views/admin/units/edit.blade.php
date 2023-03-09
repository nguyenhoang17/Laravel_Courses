@section('css')
    <link href="admin/dist/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/admin/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/admin/dist/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        #note{
            color: red;
        }
    </style>
@endsection
@extends('admin.layouts.master')
@section('title')
    Chỉnh sửa bài học
@endsection
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <form action=" {{route('units.update',['id'=>$unit->id])}} " method="post" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="put">
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Bài học</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-10 fv-row">
                            <label class="form-label">
                                Tên bài học
                                <span id="note">*</span>
                            </label>
                            <input type="text" name="name" class="form-control mb-2" placeholder=" Nhập tên bài học" value="{{$unit->name}}"/>
                            @error('name')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="mb-10 col-6" style="display:inline-block">
                                <label class="form-label">Tài liệu bài học</label><span style="color: red;"> *</span>
                                <input type="file" name="file" class="form-control mb-2" placeholder="Chọn tài liệu cho khoá học..." value="{{$unit->file}}" accept=".csv,.doc,.docx,.log,.pdf,.ppt,.pptx,.rtf,.txt,.xls,.xlsx,.xml"/>
                                @error('file')
                                <div style="color: red;" class="">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-10 col-6" style="display:inline-block">
                                <label class="form-label">Số thứ tự cho bài học</label><span style="color: red;"> *</span>
                                <input class="form-control mb-2" type="number" min="1" name="index" placeholder="thêm số thứ tự" value="{{$unit->index}}">
                                @error('index')
                                <div style="color: red;" class="">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        @if($unit->course->type == \App\Models\Course::TYPE_ONDEMAND)
                        <div id="video__course" class="col-6 key_live">
                            <div class="card card-flush py-4">
                                {{--							<!--begin::Card header-->--}}
                                <div class="card-header">
                                    {{--								<!--begin::Card title-->--}}
                                    <div class="card-title">
                                        <p>Video</p><span style="color: red;"> *</span>
                                    </div>
                                    {{--								<!--end::Card title-->--}}
                                </div>
                                {{--							<!--end::Card header-->--}}
                                {{--							<!--begin::Card body-->--}}
                                <div class="card-body text-center pt-0">
                                    {{--								<!--begin::Image input-->--}}
                                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(admin/dist/media/svg/files/blank-image.svg)">
                                        {{--									<!--begin::Preview existing avatar-->--}}
                                        <div style="display: inline-block; border: 3px solid #fff; box-shadow: 0 0.1rem 1rem 0.25rem rgb(0 0 0 / 5%);" class="video-prev ">
                                            <video src="{{url(\Illuminate\Support\Facades\Storage::url($unit->video))}}" id="video_course" height="500" width="500" class="video-preview" controls="controls">
                                        </div>
                                        {{--									<!--end::Preview existing avatar-->--}}
                                        {{--									<!--begin::Label-->--}}
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Thay đổi video">
                                            {{--										<!--begin::Icon-->--}}
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            {{--										<!--end::Icon-->--}}
                                            {{--										<!--begin::Inputs-->--}}
                                            <input class="upload-video-file" type="file" name="video" value="{{$unit->video}}" accept=".flv, .mp4, .m3u8, .ts, .3gp, .mov, .avi, .wmv" />
                                            <input type="hidden" name="video_remove" id=""/>
                                            {{--										<!--end::Inputs-->--}}
                                        </label>
                                        {{--									<!--end::Label-->--}}
                                        {{--									<!--begin::Cancel-->--}}
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                            <i class="bi bi-x fs-2" id="remove_video"></i>
                                        </span>
                                        {{--									<!--end::Cancel-->--}}
                                        {{--									<!--begin::Remove-->--}}
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        {{--									<!--end::Remove-->--}}

                                    </div>
                                    {{--								<!--end::Image input-->--}}
                                    @error('video')
                                    <div style="color: red;" class="">{{$message}}</div>
                                    @enderror
                                    <div class="text-muted fs-7">Thêm video cho khoá học. Chỉ các tệp video *.flv, *.mp4, *.m3u8, *.ts, *.3gp, *.mov, *.avi và *.wmv được chấp nhận</div>
                                    {{--								<!--end::Description-->--}}
                                </div>
                                {{--							<!--end::Card body-->--}}
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href=" {{route('units.index',['course_id'=>$course->id])}} "  id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Hủy</a>
                        <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                            <span class="indicator-label">Chỉnh sửa</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="/admin/dist/assets/js/units/create.js"></script>
@endsection
