@extends('admin.layouts.master')
@section('content-header')
	<div class="toolbar" id="kt_toolbar">
		<div class="toolbar" id="kt_toolbar">
			<!--begin::Container-->
			<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div
					data-kt-swapper="true"
					data-kt-swapper-mode="prepend"
					data-kt-swapper-parent="
						{
							default: '#kt_content_container', 'lg': '#kt_toolbar_container'
						}"
							class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
					<!--begin::Title-->
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">
									Chỉnh sửa thông tin cá nhân
					<!--begin::Separator-->
					<span class="h-20px border-1 border-gray-200 border-start ms-3 mx-2 me-1"></span>
					<!--end::Separator-->
					<!--begin::Description-->
					<!--end::Description-->
				</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
		
				<!--end::Actions-->
			</div>
									<!--end::Container-->
		</div>
	</div>
@endsection
@section('content')
	<div id="kt_content_container" class="container-xxl">
		<div class="card mb-5 mb-xl-10">
			<!--begin::Card header-->
			<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
				<!--begin::Card title-->
				<div class="card-title m-0">
					<h3 class="fw-bolder m-0">Thông tin cá nhân</h3>
				</div>
				<!--end::Card title-->
			</div>
			<!--begin::Card header-->
			<!--begin::Content-->
			<div id="kt_account_settings_profile_details" class="collapse show">
				<!--begin::Form-->
				<form action="{{ route('settings.admin.update',Auth::guard('admin')->user()->id) }}" id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST">
					@csrf
					<!--begin::Card body-->
					<div class="card-body border-top p-9">
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label required fw-bold fs-6">Tên</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8">
								<!--begin::Row-->
								<div class="row">
									<!--begin::Col-->
									<div class="col-lg-12 fv-row fv-plugins-icon-container">
										<input type="text" name="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Nhập tên..." value="@if(!empty(old("name"))){{old("name")}}@else{{ Auth::guard('admin')->user()->name }}@endif">
										@error('name')
											<div class="fv-plugins-message-container invalid-feedback">
												<div>{{ $message }}</div>
											</div>
										@enderror									
										<div class="fv-plugins-message-container invalid-feedback"></div></div>
									<!--end::Col-->
								</div>
								<!--end::Row-->
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row fv-plugins-icon-container">
								<input type="text" name="email" disabled="disabled" class="form-control form-control-lg" placeholder="Email" value="{{ Auth::guard('admin')->user()->email }}">
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label fw-bold fs-6">
								<span class="required">Số điện thoại</span>
							</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row fv-plugins-icon-container">
								<input type="text" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Nhập số điện thoại..." value="@if(!empty(old("phone"))){{old("phone")}}@else{{ Auth::guard('admin')->user()->phone }}@endif">
								@error('phone')
									<div class="fv-plugins-message-container invalid-feedback">
										<div>{{ $message }}</div>
									</div>
								@enderror							
								<div class="fv-plugins-message-container invalid-feedback"></div></div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label fw-bold fs-6">
								<span class="required">Địa chỉ</span>
							</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row">
								<input type="text" name="address" class="form-control form-control-lg form-control-solid" placeholder="Nhập địa chỉ..." value="@if(!empty(old("address"))){{old("address")}}@else{{ Auth::guard('admin')->user()->address }}@endif">
								@error('address')
									<div class="fv-plugins-message-container invalid-feedback">
										<div>{{ $message }}</div>
									</div>
								@enderror	
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label required fw-bold fs-6">Giới tính</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row fv-plugins-icon-container">
								<select name="gender" class="form-select form-select-solid form-select-lg"  aria-label="Select example">
									@foreach (\App\Models\Staff::$genderArr as $item)
										<option value="{{$item}}" {{ (Auth::guard('admin')->user()->gender == $item) ? 'selected' : '' }}>
											@if($item==App\Models\Staff::GENDER_MALE) Nam
											@elseif($item==App\Models\Staff::GENDER_FEMALE) Nữ
											@endif
										</option>
									@endforeach
								</select>
							<div class="fv-plugins-message-container invalid-feedback"></div></div>
							<!--end::Col-->
						</div>
					</div>
					<!--end::Card body-->
					<!--begin::Actions-->
					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Lưu</button>
					</div>
					<!--end::Actions-->
				<input type="hidden"><div></div></form>
				<!--end::Form-->
			</div>
			<!--end::Content-->
		</div>
	</div>
	<div id="kt_content_container" class="container-xxl">
		<div class="card mb-5 mb-xl-10">
			<!--begin::Card header-->
			<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
				<!--begin::Card title-->
				<div class="card-title m-0">
					<h3 class="fw-bolder m-0">Đổi mật khẩu</h3>
				</div>
				<!--end::Card title-->
			</div>
			<!--begin::Card header-->
			<!--begin::Content-->
			<div id="kt_account_settings_profile_details" class="collapse show">
				<!--begin::Form-->
				<form id="form-submit" action="{{ route('settings.admin.change',Auth::guard('admin')->user()->id) }}" id="main-form" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST">
					@csrf
					<!--begin::Card body-->
					<div class="card-body border-top p-9">
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label required fw-bold fs-6">Mật khẩu hiện tại</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8">
								<!--begin::Row-->
								<div class="row">
									<!--begin::Col-->
									<div class="col-lg-12 fv-row fv-plugins-icon-container">
										<input type="password" name="current_password" id="current_password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Nhập mật khẩu hiện tại..." value="{{ old('current_password') }}">
										@error('current_password')
											<div class="fv-plugins-message-container invalid-feedback">
												<div>{{ $message }}</div>
											</div>
										@enderror									
										<div class="fv-plugins-message-container invalid-feedback"></div></div>
									<!--end::Col-->
								</div>
								<!--end::Row-->
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label fw-bold fs-6">
								<span class="required">Mật khẩu mới</span>
							</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row fv-plugins-icon-container">
								<input type="password" name="new_password" id="new_password" class="form-control form-control-lg form-control-solid" placeholder="Nhập mật khẩu mới..." value="{{ old('new_password') }}">
								@error('new_password')
									<div class="fv-plugins-message-container invalid-feedback">
										<div>{{ $message }}</div>
									</div>
								@enderror							
								<div class="fv-plugins-message-container invalid-feedback"></div></div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="row mb-6">
							<!--begin::Label-->
							<label class="col-lg-4 col-form-label fw-bold fs-6">
								<span class="required">Xác nhận mật khẩu mới</span>
							</label>
							<!--end::Label-->
							<!--begin::Col-->
							<div class="col-lg-8 fv-row">
								<input type="password" name="re_new_password" id="re_new_password" class="form-control form-control-lg form-control-solid" placeholder="Xác nhận mật khẩu mới..." value="{{ old('re_new_password') }}">
								@error('re_new_password')
									<div class="fv-plugins-message-container invalid-feedback">
										<div>{{ $message }}</div>
									</div>
								@enderror	
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
					</div>
					<!--end::Card body-->
					<!--begin::Actions-->
					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<button type="button" class="btn btn-primary" id="change_password">Lưu</button>
					</div>
					<!--end::Actions-->
				<input type="hidden"><div></div></form>
				<!--end::Form-->
			</div>
			<!--end::Content-->
		</div>	
	</div>
@endsection
@section('js')
	<script src="/admin/dist/assets/js/setting.js"></script>
@endsection
