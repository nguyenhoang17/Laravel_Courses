@extends('admin.layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="/admin/dist/assets/css/tags/fontawesome.css" />
    <link  rel="stylesheet" type="text/css" href="/admin/dist/assets/css/tags/tags.css"/>
    <link href="/admin/dist/assets/css/edit/editList.css" rel="stylesheet"/>
@endsection
@section('title')
    Danh sách thẻ
@endsection
@section('content')
    <div id="" class="container-xxl">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <!-- Search -->
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="searchTag"
                            name="search"
                            class="form-control form-control-solid  w-350px ps-14 menu-link"
                            data-kt-ecommerce-category-filter="search"
                            placeholder="Nhập tên để tìm kiếm" />
                    </div>
                </div>
                <!-- Create -->
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('tags.create') }}" class="btn btn-primary">
                        <span class="svg-icon svg-icon-2">
                        </span>Tạo mới
                        </a>
                    </div>
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-category-table-toolbar="selected">
                        <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-category-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-danger" data-kt-category-table-select="delete_selected">Delete Selected</button>
                    </div>
                    <div class="modal fade" id="kt_modal_export_category" tabindex="-1" aria-hidden="true">
                    </div>
                    <div class="modal fade" id="kt_modal_add_category" tabindex="-1" aria-hidden="true">
                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="table">
                    <thead>
                        <tr  style="text-transform: none !important;" class="text-start text-muted fw-bolder fs-7 gs-0">
                            <th class="min-w-100px">Tên</th>
                            <th class="min-w-150px">Thời gian tạo</th>
                            <th class="min-w-150px">Thời gian sửa</th>
                            <th class="min-w-100px" style="text-align: center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-bold">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="/admin/dist/assets/js/tags/sweetalert2.js"></script>
    <script src="/admin/dist/assets/js/tags/tag.js"></script>
    <script src="/admin/dist/assets/js/tags/fontanwesome.js"></script>
@endsection
