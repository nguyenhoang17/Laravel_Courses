@section('css')
    <link href="/admin/dist/assets/css/categories/categories.css" rel="stylesheet" type="text/css" />
@endsection
@extends('admin.layouts.master')
@section('title')
    Danh sách danh mục
@endsection
@section('content')
<div id="kt_content_container" class="container-xxl">
	<form
		method="POST"
		action="{{ route('categories.store') }}"
		enctype="multipart/form-data"
		id="kt_ecommerce_add_category_form"
		class="form d-flex flex-column flex-lg-row">
		@csrf
		<!--begin::Aside column-->
		<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
			<!--begin::Thumbnail settings-->
			<div class="card card-flush py-4">
				<!--begin::Card header-->
				<div class="card-header">
					<!--begin::Card title-->
					<div class="card-title">
						<h2>Ảnh danh mục
							<span style="color:red" >*</span>
						</h2>
					</div>
					<!--end::Card title-->
				</div>
				<!--end::Card header-->
				<!--begin::Card body-->
				<div style="padding-bottom: 40px;" class="card-body text-center pt-0">
					<!--begin::Image input-->
					<div
						class="image-input image-input-empty image-input-outline mb-3"
						data-kt-image-input="true"
						style="background-image: url(admin/dist/media/svg/files/blank-image.svg)">
						<!--begin::Preview existing avatar-->
						<div class="image-input-wrapper w-150px h-150px"></div>
						<!--end::Preview existing avatar-->
						<!--begin::Label-->
						<label
							class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
							data-kt-image-input-action="change"
							data-bs-toggle="tooltip"
							title="Chọn ảnh">
							<!--begin::Icon-->
							<i class="bi bi-pencil-fill fs-7"></i>
							<!--end::Icon-->
							<!--begin::Inputs-->
							<input multiple type="file" name="avatar" accept=".png, .jpg, .jpeg" />

							<!--end::Inputs-->
						</label>
						<!--end::Label-->
						<!--begin::Cancel-->

						<!--end::Cancel-->
						<!--begin::Remove-->
						<span
							class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
							data-kt-image-input-action="remove"
							data-bs-toggle="tooltip"
							title="Remove avatar">
							<i class="bi bi-x fs-2"></i>
						</span>
						<!--end::Remove-->
					</div>
					<!--end::Image input-->
					<!--begin::Description-->
					<div class="text-muted fs-7">
					@error('avatar')
													<span class="alert ">{{ $message }}</span>
					@enderror
					<!--end::Description-->
					</div>
				</div>
				<!--end::Card body-->
			</div>
			<!--end::Thumbnail settings-->
			<!--begin::Status-->
			<!--end::Status-->
			<!--begin::Template settings-->

			<!--end::Template settings-->
		</div>
		<!--end::Aside column-->
		<!--begin::Main column-->
		<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
			<!--begin::General options-->
			<div class="card card-flush py-4">
				<!--begin::Card header-->
				<div class="card-header">
					<div class="card-title">
						<h2>Danh mục</h2>
					</div>
				</div>
				<!--end::Card header-->
				<!--begin::Card body-->
				<div class="card-body pt-0">
					<!--begin::Input group-->
					<div class="mb-10 fv-row">
						<!--begin::Label-->
						<label class="form-label">Tên danh mục
							<span  style="color:red">*</span>
						</label>
						<!--end::Label-->
						<!--begin::Input-->
						<input
							type="text"
							name="name"
							class="form-control mb-2"
							placeholder="Tên danh mục"
							value="{{old('name')}}" />
							@error('name')
											<span class="alert ">{{ $message }}</span>
							@enderror
						<!--end::Input-->
						<!--begin::Description-->
						<!--end::Description-->
					</div>
					<!--end::Input group-->
					<!--begin::Input group-->
					<div>
						<!--begin::Label-->
						<label class="form-label">Mô tả</label>
						<!--end::Label-->
						<!--begin::Editor-->
						<input
								type="text"
								name="description"
								class="form-control mb-2"
								placeholder="Mô tả"
								value="{{old('description')}}" />
					</div>
					<!--end::Input group-->
				</div>
				<!--end::Card header-->
			</div>
			<div class="d-flex justify-content-end">
				<!--begin::Button-->
				<a
						href="{{ route('categories.list') }}"
						id="kt_ecommerce_add_product_cancel"
						class="btn btn-light me-5">
						Hủy
				</a>
				<!--end::Button-->
				<!--begin::Button-->
				<button id="kt_ecommerce_add_category_submit" class="btn btn-primary" type="submit">
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
@endsection
@section('js')
<script
				src="https://code.jquery.com/jquery-3.6.0.min.js"
				integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
				crossorigin="anonymous">
</script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
</script>
@endsection
