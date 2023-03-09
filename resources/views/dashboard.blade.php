@section('css')
    <link href="/admin/dist/assets/css/edit/editList.css" rel="stylesheet"/>
    <link href="/admin/dist/assets/css/courses/fontanwesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection
@extends('admin.layouts.master')
@section('title')
    Tổng quan
@endsection
@section('content')
    <style>
        .flex-root {
            flex: 0;
            flex-grow: 0;
            flex-shrink: 0;
            flex-basis: 0%;
        }
        .footer{
            margin-top: 70px;
        }
        .content{
            padding: 0 !important;
        }
        .card-body1{
            padding: 0 !important;
        }
        .statistical{
            width: 30%;
            height: 180px;
            border-radius: 18px;
            background-color: red;
            margin: 30px;
            color: #ffffff;
            padding: 30px;
        }
    </style>
    <div style="width: 100%" id="" class="">

        <!--begin::Card-->
        <div class="card" >
            <div style="width: 100%; display: flex" class="mb-10">
                <div class="statistical" style="background-color: #7239EA">
                    <div class="card-body1">
                        <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm002.svg-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M21 10H13V11C13 11.6 12.6 12 12 12C11.4 12 11 11.6 11 11V10H3C2.4 10 2 10.4 2 11V13H22V11C22 10.4 21.6 10 21 10Z" fill="currentColor"></path>
													<path opacity="0.3" d="M12 12C11.4 12 11 11.6 11 11V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V11C13 11.6 12.6 12 12 12Z" fill="currentColor"></path>
													<path opacity="0.3" d="M18.1 21H5.9C5.4 21 4.9 20.6 4.8 20.1L3 13H21L19.2 20.1C19.1 20.6 18.6 21 18.1 21ZM13 18V15C13 14.4 12.6 14 12 14C11.4 14 11 14.4 11 15V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18ZM17 18V15C17 14.4 16.6 14 16 14C15.4 14 15 14.4 15 15V18C15 18.6 15.4 19 16 19C16.6 19 17 18.6 17 18ZM9 18V15C9 14.4 8.6 14 8 14C7.4 14 7 14.4 7 15V18C7 18.6 7.4 19 8 19C8.6 19 9 18.6 9 18Z" fill="currentColor"></path>
												</svg>
											</span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bold fs-2 mb-2 mt-5"><h1 class="text-white">Khoá học đã bán</h1></div>
                        <div style="font-size: 20px" class="fw-semibold text-white">{{count($courseSold)}}</div>
                    </div>
                </div>
                <div class="statistical" style="background-color: #f1416c">
                    <div class="card-body1">
                        <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="currentColor"></path>
													<path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="currentColor"></path>
													<path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="currentColor"></path>
												</svg>
											</span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bold fs-2 mb-2 mt-5"><h1 class="text-white">Khách hàng</h1></div>
                        <div style="font-size: 20px" class="fw-semibold text-white">{{count($users)}}</div>
                    </div>
                </div>
                <div class="statistical" style="background-color: #50cd89">
                    <div class="card-body1">
                        <!--begin::Svg Icon | path: icons/duotune/graphs/gra005.svg-->
                        <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path opacity="0.3" d="M14 12V21H10V12C10 11.4 10.4 11 11 11H13C13.6 11 14 11.4 14 12ZM7 2H5C4.4 2 4 2.4 4 3V21H8V3C8 2.4 7.6 2 7 2Z" fill="currentColor"></path>
													<path d="M21 20H20V16C20 15.4 19.6 15 19 15H17C16.4 15 16 15.4 16 16V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="currentColor"></path>
												</svg>
											</span>
                        <!--end::Svg Icon-->
                        <div class="text-white fw-bold fs-2 mb-2 mt-5"><h1 class="text-white">Doanh thu</h1></div>
                        <div style="font-size: 20px" class="fw-semibold text-white">{{number_format($revenue)}}đ</div>
                    </div>
                </div>
            </div>
            <form action="" method="POST" class="form d-flex flex-column flex-lg-row">
                @csrf
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-body pt-0 fv-row" style="display: inline-block">
                            <div class="mb-10" style="width: 300px; display: inline-block" >
                                <label class="form-label">
                                    Từ ngày
                                </label>
                                <input name="from_date" type="text" id="datepicker1" class="form-control mb-2" placeholder="Chọn ngày"/>
                            </div>
                            <div class="mb-10" style="width: 300px; display: inline-block; margin-left: 10px">
                                <label class="form-label">
                                    Đến ngày
                                </label>
                                <input name="to_date" type="text" id="datepicker2" class="form-control mb-2" placeholder="Chọn ngày"/>
                            </div>
                            <div style="display: inline-block; margin-left: 20px">
                                <input type="button" id="btn-dashboard-filter" class="btn btn-primary" value="Lọc kết quả">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-6">
                    <h2>Thống kê đơn hàng</h2>
                    <div id="myfirstchart" style="height: 250px;"></div>
                </div>
                <div class="col-6">
                    <h2>Thống kê doanh thu</h2>
                    <div id="myfirstchart2" style="height: 250px;"></div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script type="text/javascript">
        $.datepicker.regional["vi-VN"] =
            {
                closeText: "Đóng",
                prevText: "Trước",
                nextText: "Sau",
                currentText: "Hôm nay",
                monthNames: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                monthNamesShort: ["Một", "Hai", "Ba", "Bốn", "Năm", "Sáu", "Bảy", "Tám", "Chín", "Mười", "Mười một", "Mười hai"],
                dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
                dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
                dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                weekHeader: "Tuần",
                dateFormat: "yy-mm-dd",
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ""
            };
        $( function() {
            $( "#datepicker1" ).datepicker($.datepicker.regional["vi-VN"]);
        } );
        $( function() {
            $( "#datepicker2" ).datepicker($.datepicker.regional["vi-VN"]);
        } );
        $(document).ready(function() {
            function revenueOrder(){
                var _token = $('input[name = "_token"]').val();
                var from_date = $('#datepicker1').val();
                var to_date = $('#datepicker2').val();

                $.ajax({
                    url: '{{route('admin.dashboard.fillter')}}',
                    method: "POST",
                    dataType: "JSON",
                    data: {from_date: from_date, to_date: to_date, _token: _token},

                    success: function (data) {
                        chart.setData(data);
                    }
                })
            };
            function revenueTotal(){
                var _token = $('input[name = "_token"]').val();
                var from_date = $('#datepicker1').val();
                var to_date = $('#datepicker2').val();

                $.ajax({
                    url: '{{route('admin.dashboard.fillter')}}',
                    method: "POST",
                    dataType: "JSON",
                    data: {from_date: from_date, to_date: to_date, _token: _token},

                    success: function (data) {
                        chart2.setData(data);
                    }
                })
            };
            revenueOrder();
            revenueTotal();
            $('#btn-dashboard-filter').click(function () {
                var _token = $('input[name = "_token"]').val();
                var from_date = $('#datepicker1').val();
                var to_date = $('#datepicker2').val();

                $.ajax({
                    url: '{{route('admin.dashboard.fillter')}}',
                    method: "POST",
                    dataType: "JSON",
                    data: {from_date: from_date, to_date: to_date, _token: _token},

                    success: function (data) {
                        chart.setData(data);
                    }
                })
            });

            $('#btn-dashboard-filter').click(function () {
                var _token = $('input[name = "_token"]').val();
                var from_date = $('#datepicker1').val();
                var to_date = $('#datepicker2').val();

                $.ajax({
                    url: '{{route('admin.dashboard.fillter')}}',
                    method: "POST",
                    dataType: "JSON",
                    data: {from_date: from_date, to_date: to_date, _token: _token},

                    success: function (data) {
                        chart2.setData(data);
                    }
                })
            });

            var chart = new Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart',
                parseTime:false,

                xkey: 'period',

                ykeys: ['order'],
                behaveLikeLine: true,

                labels: ['đơn hàng']
            });
            var chart2 = new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart2',
                parseTime:false,

                xkey: 'period',

                ykeys: ['price'],
                behaveLikeLine: true,

                labels: ['doanh thu']
            });
        });

    </script>
@endsection

