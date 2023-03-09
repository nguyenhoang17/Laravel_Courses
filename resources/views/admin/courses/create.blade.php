@extends('admin.layouts.master')
@section('css')
    <link href="/admin/dist/assets/css/courses/fontanwesome.css" rel="stylesheet"/>
    <link href="/admin/dist/assets/css/courses/create.css" rel="stylesheet"/>
@endsection
@section('title')
    Danh sách khóa học
@endsection
@section('content')
<div id="kt_content_container" class="container-xxl">
	<form id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row row" action="{{route('courses-manager.store')}}" method="POST" enctype="multipart/form-data">
		@csrf
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
						<input type="text" name="name" class="form-control mb-2" placeholder="Nhập tên khoá học..." value="{{old('name')}}" />
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
						<select class="form-select mb-2" name="category_id" id="cars" value="{{old('category_id')}}">
							<option value="">--Chọn danh mục--</option>
                            @foreach($categories as $key => $category)
							    <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
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
						<select class="form-select mb-2" name="staff_id" id="cars" value="{{old('staff_id')}}">
							<option value="">--Chọn giảng viên--</option>
							@foreach($teachers as $key => $teacher)
								<option value="{{$teacher->id}}" {{ old('staff_id') == $teacher->id ? 'selected' : '' }}>{{$teacher->name}}</option>
							@endforeach
							</select>
                            @error('staff_id')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
					</div>

{{--					<div class="mb-10 col-6" style="display:inline-block">--}}
{{--						<label class="form-label">Tài liệu khoá học</label><span style="color: red;"> *</span>--}}
{{--						<input type="file" name="files[]" class="form-control mb-2" placeholder="Chọn tài liệu cho khoá học..." value="{{old('files[]')}}" multiple accept=".csv,.doc,.docx,.log,.pdf,.ppt,.pptx,.rtf,.txt,.xls,.xlsx,.xml"/>--}}
{{--                        @error('files.*')--}}
{{--                        <div style="color: red;" class="">{{$message}}</div>--}}
{{--                        @enderror--}}
{{--                        @error('files')--}}
{{--                        <div style="color: red;" class="">{{$message}}</div>--}}
{{--                        @enderror--}}
{{--					</div>--}}
                    <div class="mb-10 col-6" style="display:inline-block">
                        <label class="form-label">Chọn tag</label><span style="color: red;"> *</span>
                        <select name="tags[]" class="form-select form-select-solid" data-control="select2" data-placeholder="Chọn Tag cho khoá học" data-allow-clear="true" multiple="multiple">
                            <option></option>
                            @if(count($tags)==0)
                                <option disabled >Không có dữ liệu</option>
                            @endif
                            @if($tags)
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}" {{in_array($tag->id, old("tags") ?: []) ? "selected" : ""}}>{{$tag->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('tags')
                        <div style="color: red;" class="">{{$message}}</div>
                        @enderror
                    </div>
					<!--Chọn loại khoá học-->

					<div class="mb-10 col-6" style="display:inline-block">
						<!--begin::Label-->
						<label class="form-label">Loại khoá học</label><span style="color: red;"> *</span>
						<select class="form-select mb-2" name="type" id="type_course" >
							<option value="" @if(empty(old('type'))){{'selected'}}@endif disabled>--Chọn loại khoá học--</option>
                            <option value="{{App\Models\Course::TYPE_LIVE}}" {{ old('type') == App\Models\Course::TYPE_LIVE ? 'selected' : '' }}>Khoá học qua skype</option>
                            <option value="{{App\Models\Course::TYPE_ONDEMAND}}" {{ old('type') == App\Models\Course::TYPE_ONDEMAND ? 'selected' : '' }}>Khoá học xem video</option>
                        </select>
                        @error('type')
                        <div style="color: red;" class="">{{$message}}</div>
                        @enderror
					</div>

					<div class="col-6">
						<label class="form-label">Giá tiền</label><span style="color: red;"> *</span>
						<input type="text" name="price" class="form-control mb-2" placeholder="Nhập giá tiền..." value="{{old('price')}}" />
                        @error('price')
                        <div style="color: red;" class="">{{$message}}</div>
                        @enderror
					</div>

					{{-- key --}}
					<div id="option__live" class="mb-10 col-6 key_live">
						<label class="form-label">Link phòng học skype</label><span style="color: red;"> *</span>
						<!--end::Label-->
						<!--begin::Input-->
						<input type="text" name="key" class="form-control mb-2" placeholder="Nhập link phòng học..." value="{{old('key')}}" />
                        @error('key')
                        <div style="color: red;" class="">{{$message}}</div>
                        @enderror
					</div>


					<div class="mb-10 fv-row">
						<!--begin::Label-->
						<label class="form-label">Mô tả</label>
						<!--end::Label-->
						<!--begin::Editor-->
						<textarea class="form-control mb-2" style="width:100%;" name="description" id="" rows="4" placeholder="Nhập mô tả..." >{{old('description')}}</textarea>
						<!--end::Editor-->
						<!--begin::Description-->
						<!--end::Description-->
					</div>
					<div class="mb-10 col-6">
						<div class="mb-10 col-12">
							<label class="form-label">Thời gian bắt đầu </label><span style="color: red;"> *</span>
							<!--end::Label-->
							<!--begin::Input-->

                            <input name="start_time" value="{{old('start_time')}}" class="form-control form-control-solid" placeholder="Chọn thời gian bắt đầu khoá học" id="kt_datepicker_3" class="kt_datepicker_3"/>
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

                            <input name="end_time" value="{{old('end_time')}}" class="form-control form-control-solid" placeholder="Chọn thời gian kết thúc khoá học" id="kt_datepicker_4"/>
                            @error('end_time')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror

						</div>
					</div>
                    <div class="mb-10 col-12" style="display:inline-block">
                        <p>Khoá học nổi bật</p>
                        <div style="" id="check_featured" class="form-check form-check-solid form-switch">
                            <input name="is_featured" value="@if(!empty(old('is_featured'))) {{old('is_featured')}}@else {{0}} @endif" id="featured" class="delee form-check-input w-55px h-30px" type="checkbox"/>
                            <label class="form-check-label" for="googleswitch"></label>
                            <style>
                                #featured{
                                    background-color: #ccc;
                                }
                            </style>
                        </div>
                    </div>

{{--					<div id="video__course" class="col-6 key_live">--}}
{{--						<div class="card card-flush py-4">--}}
{{--							<!--begin::Card header-->--}}
{{--							<div class="card-header">--}}
{{--								<!--begin::Card title-->--}}
{{--								<div class="card-title">--}}
{{--									<p>Video</p><span style="color: red;"> *</span>--}}
{{--								</div>--}}
{{--								<!--end::Card title-->--}}
{{--							</div>--}}
{{--							<!--end::Card header-->--}}
{{--							<!--begin::Card body-->--}}
{{--							<div class="card-body text-center pt-0">--}}
{{--								<!--begin::Image input-->--}}
{{--								<div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(admin/dist/media/svg/files/blank-image.svg)">--}}
{{--									<!--begin::Preview existing avatar-->--}}
{{--									<div style="display: inline-block; border: 3px solid #fff; box-shadow: 0 0.1rem 1rem 0.25rem rgb(0 0 0 / 5%);" class="video-prev ">--}}
{{--										<video id="video_course" height="500" width="500" class="video-preview" controls="controls">--}}
{{--									</div>--}}
{{--									<!--end::Preview existing avatar-->--}}
{{--									<!--begin::Label-->--}}
{{--									<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Thay đổi video">--}}
{{--										<!--begin::Icon-->--}}
{{--										<i class="bi bi-pencil-fill fs-7"></i>--}}
{{--										<!--end::Icon-->--}}
{{--										<!--begin::Inputs-->--}}
{{--										<input class="upload-video-file" type="file" name="video" value="{{old('video')}}" accept=".flv, .mp4, .m3u8, .ts, .3gp, .mov, .avi, .wmv" />--}}
{{--										<input type="hidden" name="video_remove" id=""/>--}}
{{--										<!--end::Inputs-->--}}
{{--									</label>--}}
{{--									<!--end::Label-->--}}
{{--									<!--begin::Cancel-->--}}
{{--									<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">--}}
{{--										<i class="bi bi-x fs-2" id="remove_video"></i>--}}
{{--									</span>--}}
{{--									<!--end::Cancel-->--}}
{{--									<!--begin::Remove-->--}}
{{--									--}}{{-- <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">--}}
{{--										<i class="bi bi-x fs-2"></i>--}}
{{--									</span> --}}
{{--									<!--end::Remove-->--}}

{{--								</div>--}}
{{--								<!--end::Image input-->--}}
{{--                                @error('video')--}}
{{--                                <div style="color: red;" class="">{{$message}}</div>--}}
{{--                                @enderror--}}
{{--								<div class="text-muted fs-7">Thêm video cho khoá học. Chỉ các tệp video *.flv, *.mp4, *.m3u8, *.ts, *.3gp, *.mov, *.avi và *.wmv được chấp nhận</div>--}}
{{--								<!--end::Description-->--}}
{{--							</div>--}}
{{--							<!--end::Card body-->--}}
{{--						</div>--}}
{{--					</div>--}}
					<div class="col-6">
						<div class="card card-flush py-4">
							<!--begin::Card header-->
							<div class="card-header">
								<!--begin::Card title-->
								<div class="card-title">
									<p>Ảnh</p><span style="color: red;"> *</span>
								</div>
								<!--end::Card title-->
							</div>
							<!--end::Card header-->
							<!--begin::Card body-->
							<div class="card-body text-center pt-0">
								<!--begin::Image input-->
								<div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(admin/dist/media/svg/files/blank-image.svg)">
									<!--begin::Preview existing avatar-->
									<div class="image-input-wrapper w-500px h-500px"></div>
									<!--end::Preview existing avatar-->
									<!--begin::Label-->
									<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Thay đổi ảnh">
										<!--begin::Icon-->
										<i class="bi bi-pencil-fill fs-7"></i>
										<!--end::Icon-->
										<!--begin::Inputs-->
										<input type="file" value="{{old('image')}}" name="image" accept=".png, .jpg, .jpeg" />
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
									<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
										<i class="bi bi-x fs-2"></i>
									</span>
                                    @error('image')
                                    <div style="color: red;" class="">{{$message}}</div>
                                    @enderror
									<!--end::Remove-->
								</div>
								<!--end::Image input-->
								<!--begin::Description-->
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
    <script src="/admin/dist/assets/js/courses/create.js"></script>
 <script src="/admin/dist/assets/js/courses/fontanwesome.js"></script>
 <script src="/admin/dist/assets/js/courses/sweetalert.js"></script>
@endsection
