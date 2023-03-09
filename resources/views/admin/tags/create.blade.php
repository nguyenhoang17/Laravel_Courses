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
    Danh sách thẻ
@endsection
@section('content')
<div id="kt_content_container" class="container-xxl">
	<form action=" {{route('tags.store')}} " method="post" class="form d-flex flex-column flex-lg-row">
		@csrf
		<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
			<div class="card card-flush py-4">
				<div class="card-header">
					<div class="card-title">
						<h2>Tags</h2>
					</div>
				</div>
				<div class="card-body pt-0">
					<div class="mb-10 fv-row">
						<label class="form-label">
							Tên thẻ
							<span id="note">*</span>
						</label>
						<input type="text" name="name" class="form-control mb-2" placeholder=" Nhập tên thẻ" value="{{old('name')}}"/>
						@error('name')
							<div style="color: red;" class="">{{$message}}</div>
						@enderror
					</div>
				</div>
			</div>
			<div class="d-flex justify-content-end">
				<a href=" {{route('tags.list')}} "  id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Hủy</a>
				<button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
					<span class="indicator-label">Thêm mới</span>
					<span class="indicator-progress">Please wait...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
					</span>
				</button>
			</div>
		</div>
	</form>
</div>
@endsection
