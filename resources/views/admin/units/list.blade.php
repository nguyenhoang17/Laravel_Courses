@extends('admin.layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="/admin/dist/assets/css/tags/fontawesome.css" />
    <link href="/admin/dist/assets/css/edit/editList.css" rel="stylesheet"/>
@endsection
@section('title')
    Danh sách bài học của khoá học {{$course->name}} (@if($course->type==\App\Models\Course::TYPE_ONDEMAND) Video) @else Skype) @endif
@endsection
@section('content')
    <input id="id_course1" type="text" hidden value="{{$course->id}}">
    <div id="" class="container-xxl">
        <div class="card">
            <div class="card-header border-0 pt-6" style="display: block">
                <!-- Search -->
                <!-- Create -->
                <div class="card-toolbar" style="float: right">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('units.create', ["course_id" => $course->id]) }}" class="btn btn-primary">
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
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="units">
                    <thead>
                    <tr  style="text-transform: none !important;" class="text-start text-muted fw-bolder fs-7 gs-0">
                        <th class="min-w-50px">Số thứ tự</th>
                        <th class="min-w-100px">Tên bài học</th>
                        <th class="min-w-100px">Ngày tạo</th>
                        <th class="min-w-100px text-center" style="text-align: center">Hành động</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-bold">

                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="unit_detail">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 700px;">
                    <div class="modal-header">
                        <h5 class="modal-title">Chi tiết</h5>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">Thông tin bài học</h3>
                        <p class="text-muted">Thuộc khoá học: <span id="courseName" class="fw-bolder fs-6 text-dark"></span></p>
                        <p class="text-muted">Tên bài học: <span id="name" class="fw-bolder fs-6 text-dark"></span></p>
                        <div id="video"></div>
                        <div id="file"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #units > tbody > tr > td:nth-child(4){
            text-align: center;
        }
    </style>
@endsection

@section('js')
    <script src="{{asset('admin/dist/assets/js/units/list.js')}}"></script>
    <script src="{{asset('admin/dist/assets/js/units/show.js')}}"></script>
    <script src="/admin/dist/assets/js/tags/sweetalert2.js"></script>
    <script src="/admin/dist/assets/js/tags/fontanwesome.js"></script>
@endsection
