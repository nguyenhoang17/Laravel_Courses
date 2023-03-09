@section('css')
    <link href="/admin/dist/assets/css/staffs/list.css" rel="stylesheet"/>
    <link href="/admin/dist/assets/css/staffs/fontanwesome.css" rel="stylesheet"/>
    <link href="/admin/dist/assets/css/edit/editList.css" rel="stylesheet"/>
@endsection
@extends('admin.layouts.master')
@section('title')
    Danh sách nhân viên
@endsection
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
							<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
						</svg>
					</span>
                        <!--end::Svg Icon-->
                        <input style="width:400px !important;" id="search_staffs" name="search" type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Nhập tên, email, số điện thoại để tìm kiếm" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-2">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
						</svg>
					</span>
                            <!--end::Svg Icon-->Bộ lọc</button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bolder">Tuỳ chọn bộ lọc</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-user-table-filter="">
                                <form action="" method="POST" id="fillter-form">
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-bold">Quyền:</label>
                                        <select id="role" name="role" class="datatable-input form-select form-select-solid fw-bolder" data-kt-select2="true" data-placeholder="Chọn quyền" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
                                            <option id="fillter_default" value=""></option>
                                            <option value="{{\App\Models\Staff::ROLE_ADMIN}}">Quản trị viên</option>
                                            <option value="{{\App\Models\Staff::ROLE_EDITOR}}">Biên tập viên</option>
                                            <option value="{{\App\Models\Staff::ROLE_TEACHER}}">Giảng viên</option>

                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" id="reset_fllter" class="btn btn-light btn-active-light-primary fw-bold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Bỏ lọc</button>
                                        <button type="submit" class="btn btn-primary fw-bold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Lọc kết quả</button>
                                    </div>
                                </form>
                                <!--begin::Input group-->

                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Export-->
                        <!--end::Export-->
                        <!--begin::Add user-->
                        <a href="{{ route('staffs.create') }}" class="btn btn-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
					</span>
                            <!--end::Svg Icon-->Tạo mới</a>
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                        <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                        <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                    </div>
                    <!--end::Group actions-->
                    <!--begin::Modal - Adjust Balance-->
                    <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <!--end::Modal dialog-->
                    </div>
                    <!--end::Modal - New Card-->
                    <!--begin::Modal - Add task-->
                    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->

                        <!--end::Modal dialog-->
                    </div>
                    <!--end::Modal - Add task-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table id="staffs" class="">
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bolder fs-7 gs-0">
                        <th class="min-w-125px">Tên nhân viên</th>
                        <th class="min-w-125px">Email</th>
                        <th class="min-w-125px">Số điện thoại</th>
                        <th class="min-w-90px">Giới tính</th>
                        <th class="min-w-125px">Quyền</th>
                        <th style="text-align: center; padding-left:0;" class="min-w-125px">Trạng thái</th>
                        <th style="text-align: center;" class="min-w-150px">Hành động</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 700px;">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết</h5>
                </div>
                <div class=" modal-body" id="modal-result" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('admin/dist/assets/js/staffs/list.js')}}"></script>
    <script src="{{asset('admin/dist/assets/js/staffs/show.js')}}"></script>
    <script src="/admin/dist/assets/js/staffs/fontanwesome.js"></script>
    <script src="/admin/dist/assets/js/staffs/sweetalert.js"></script>
@endsection
