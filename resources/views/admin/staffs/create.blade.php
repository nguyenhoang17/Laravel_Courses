@extends('admin.layouts.master')
@section('title')
    Danh sách nhân viên
@endsection
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <form id="" class="form d-flex flex-column flex-lg-row" action="{{route('staffs.store')}}" method="post">
            @csrf
            <!--begin::Main column-->
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin::General options-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2></h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0 row">
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="form-label">Tên:</label><span style="color: red;"> *</span>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control mb-2" placeholder="Nhập tên..." value="{{old('name')}}" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <!--end::Description-->
                            @error('name')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                        </div>

                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label">Email:</label><span style="color: red;"> *</span>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <input type="email" name="email" class="form-control mb-2" placeholder="Nhập email..." value="{{old('email')}}" />
                            @error('email')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                            <!--end::Editor-->
                            <!--begin::Description-->
                            <!--end::Description-->
                        </div>
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label">Địa chỉ: </label><span style="color: red;"> *</span>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <textarea class="form-control mb-2" style="width:100%;" name="address" id="" rows="4" placeholder="Nhập địa chỉ..." >{{old('address')}}</textarea>
                            {{-- <input type="text" name="address" class="form-control mb-2" placeholder="Nhập địa chỉ..." value="{{old('address')}}" /> --}}
                            @error('address')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                            <!--end::Editor-->
                            <!--begin::Description-->
                            <!--end::Description-->
                        </div>
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label">Số điện thoại:</label><span style="color: red;"> *</span>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <input type="text" name="phone" class="form-control mb-2" placeholder="Nhập số điện thoại..." value="{{old('phone')}}" />
                            @error('phone')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                            <!--end::Editor-->
                            <!--begin::Description-->
                            <!--end::Description-->
                        </div>
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="form-label">Giới tính:</label><span style="color: red;"> *</span>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <select name="gender" class="form-select" aria-label="Select example" id="gender">
                                <option value="" @if(empty(old('gender'))){{'selected'}}@endif disabled>--Chọn giới tính--</option>
                                <option value="{{App\Models\Staff::GENDER_MALE}}" {{ old('gender') == App\Models\Staff::GENDER_MALE ? 'selected' : '' }}>Nam</option>
                                <option value="{{App\Models\Staff::GENDER_FEMALE}}" {{ old('gender') == App\Models\Staff::GENDER_FEMALE ? 'selected' : '' }}>Nữ</option>
                                {{-- <option value="{{App\Models\Staff::GENDER_MALE}}" {{ old('gender') == App\Models\Staff::GENDER_MALE ? 'selected' : '' }}>Nam</option> --}}
                            </select>
                            @error('gender')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
                            <!--end::Editor-->
                            <!--begin::Description-->
                            <!--end::Description-->
                        </div>
                        <div class="form-group col-6">
                            <label class="form-label">Quyền:</label>
                            <select name="role" class="form-select" aria-label="Select example" data-placeholder="Chọn quyền">
                                <option value="" @if(empty(old('role'))){{'selected'}}@endif disabled>--Chọn quyền--</option>
                                <option value="{{App\Models\Staff::ROLE_ADMIN}}" {{ old('role') == App\Models\Staff::ROLE_ADMIN ? 'selected' : '' }}>Quản trị viên</option>
                                <option value="{{App\Models\Staff::ROLE_EDITOR}}" {{ old('role') == App\Models\Staff::ROLE_EDITOR ? 'selected' : '' }}>Biên tập viên</option>
                                <option value="{{App\Models\Staff::ROLE_TEACHER}}" {{ old('role') == App\Models\Staff::ROLE_TEACHER ? 'selected' : '' }}>Giảng viên</option>
                            </select>
                            @error('role')
                            <div style="color: red;" class="">{{$message}}</div>
                            @enderror
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
                    <a href="{{route('staffs.index')}}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Huỷ</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="" class="btn btn-primary">
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
