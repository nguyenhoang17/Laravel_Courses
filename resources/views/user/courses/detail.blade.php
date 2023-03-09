@extends('user.layouts.master')
@section('css')
    <link rel="stylesheet" href="/user/assets/css/courses/style.css">
@endsection
@section ('title')
    Chi tiết khóa học: {{$courses->name}}
@endsection
@section ('content')
<section class="course-details-area pt-150 pb-120 pt-md-100 pb-md-70 pt-xs-100 pb-xs-70">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="courses-details-wrapper mb-30">
                    <div class="course-details-img mb-30" style="background-image: url(/storage/{{$courses->image}})">
                        <div class="video-wrapper">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-xl-12">
                <div class="learn-area mb-30">
                    <div class="price-list">
                        <h2 class="courses-title mb-30">Khóa học:  {{$courses->name}}</h2>
                        <h5 style="" ><b style="color: rgb(4, 206, 158);font-size: 35px;" class="sub-title">
                                {{number_format($courses->price,0,'.',',')}}đ</b>
                        </h5>
                    </div>
                    <div class="cart-btn">
                        <h5> Giảng viên:  {{$courses->staff->name}}</h5>
                        <h5> Cập nhật: {!! date('H:i | d/m/Y', strtotime($courses->created_at)) !!} </h5>
                    </div>
                    <div class="cart-btn" style="margin-top: 10px">
                        <h5>Ngày bắt đầu: {{date('H:i | d/m/Y', ($courses->start_time))}}</h5>
                        <h5>Số bài học: {{count($courses->units)}}</h5>
                    </div>
                    <div class="learn-box">
                        <p>{{$courses->description}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            @if(!empty($order))
                @if($order->check === false)
                @elseif(!($order->check))
                    @if(!empty(Auth::user()))
                        <div class="col-lg-12 col-md-12">
                            <div class="checkout_form_left">
                                <form
                                    id="form" action="{{ route('store-order',['course_id' => $courses->id]) }}"
                                    method="post" novalidate="novalidate">
                                    @csrf
                                    <h3 style="padding-bottom: 20px;" >Thông tin người đặt hàng</h3>
                                    <div class="row">
                                        <div  class="col-lg-6 col-md-6">
                                            <div class="form-control col-lg-6 mb-20" style="width: 100%" >
                                                <label>Họ và tên</label>
                                                <input name="name" value="{{ Auth::user()->name }}"  readonly="readonly">
                                            </div>
                                            <div class="form-control col-lg-6 mb-20">
                                                <label>Số điện thoại</label>
                                                <input readonly="readonly" value="{{ Auth::user()->phone }}"  name="phone" >
                                            </div>
                                            <div class="form-control col-lg-6 mb-20">
                                                <label>Địa chỉ email </label>
                                                <input readonly="readonly"  name="email" value="{{ Auth::user()->email }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="project-details mb-65">
                                                <h2 class="courses-title mb-30">Hình thức thanh toán</h2>
                                                <div class="pay" >
                                                    <div class="transfer">
                                                        <input
                                                            type="radio" id="f-option" class="circle-1"
                                                            onclick="myFunction()"
                                                            style="height: 18px;width: 20px;cursor: pointer"
                                                            checked value="0" name="payment_type" >
                                                        <label
                                                            class="pay-text" for="myCheck">
                                                            <i class="fa-solid fa-money-bill-transfer"></i>
                                                            Chuyển khoản
                                                        </label>
                                                        <div class="transfer-content" id="text" >
                                                            <h4>Thông tin thanh toán chuyển khoản</h4>
                                                            <ul>
                                                                <li>- Ngân hàng: VIB BANK</li>
                                                                <li>- Số tài khoản: 123456789</li>
                                                                <li>- Chủ tài khoản: Zent </li>
                                                                <li>- Tổng tiền cần chuyển:
                                                                    {{number_format($courses->price,0,'.',',')}} đ
                                                                </li>
                                                                <li>- Nội dung chuyển khoản: Thanh toán khóa học:
                                                                    {{$courses->name}}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
{{--                                                    <div class="vnPay" >--}}
{{--                                                        <input--}}
{{--                                                            type="radio" id="g-option" class="circle-2"--}}
{{--                                                            onclick="checkVnpay()" style="height: 18px;width: 20px;cursor: pointer"--}}
{{--                                                            value="1" name="payment_type">--}}
{{--                                                        <label--}}
{{--                                                            class="pay-text"> <img style="width: 20%;"--}}
{{--                                                           `src="https://vnpay.vn/_nuxt/img/logo-primary.55e9c8c.svg" />--}}
{{--                                                            Thanh toán băng VNPAY--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
                                                </div>
                                                <div class="order_button">
                                                    <a onclick="deleteCategories()" id="order_btn" >Thanh toán</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <span style="font-size: 20px " >Vui lòng <a style="color: #FF723A;font-weight: 700;" href="{{route('user.login')}}">Đăng nhập</a> hoặc
                            <a style="color: #FF723A;font-weight: 700;" href="{{route('user.register')}}">Đăng kí</a> để mua khóa học này!
                        </span>
                    @endif
                @endif
            @else
                @if(!empty(Auth::user()))
                    <div class="col-lg-12 col-md-12">
                        <div class="checkout_form_left">
                            <form
                                id="form" action="{{ route('store-order',['course_id' => $courses->id]) }}"
                                method="post" novalidate="novalidate">
                                @csrf
                                <h3 style="padding-bottom: 20px;" >Thông tin người đặt hàng</h3>
                                <div class="row">
                                    <div  class="col-lg-6 col-md-6">
                                        <div class="form-control col-lg-6 mb-20" style="width: 100%" >
                                            <label>Họ và tên</label>
                                            <input name="name" value="{{ Auth::user()->name }}"  readonly="readonly">
                                        </div>
                                        <div class="form-control col-lg-6 mb-20">
                                            <label>Số điện thoại</label>
                                            <input readonly="readonly" value="{{ Auth::user()->phone }}"  name="phone" >
                                        </div>
                                        <div class="form-control col-lg-6 mb-20">
                                            <label>Địa chỉ email </label>
                                            <input readonly="readonly"  name="email" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="project-details mb-65">
                                            <h2 class="courses-title mb-30">Hình thức thanh toán</h2>
                                            <div class="pay" >
                                                <div class="transfer">
                                                    <input
                                                        type="radio" id="f-option" class="circle-1"
                                                        onclick="myFunction()"
                                                        style="height: 18px;width: 20px;cursor: pointer"
                                                        checked value="0" name="payment_type" >
                                                    <label
                                                        class="pay-text" for="myCheck">
                                                        <i class="fa-solid fa-money-bill-transfer"></i>
                                                        Chuyển khoản
                                                    </label>
                                                    <div class="transfer-content" id="text" >
                                                        <h4>Thông tin thanh toán chuyển khoản</h4>
                                                        <ul>
                                                            <li>- Ngân hàng: VIB BANK</li>
                                                            <li>- Số tài khoản: 123456789</li>
                                                            <li>- Chủ tài khoản: Zent </li>
                                                            <li>- Tổng tiền cần chuyển:
                                                                {{number_format($courses->price,0,'.',',')}} đ
                                                            </li>
                                                            <li>- Nội dung chuyển khoản: Thanh toán khóa học:
                                                                {{$courses->name}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
{{--                                                <div class="vnPay" >--}}
{{--                                                    <input--}}
{{--                                                        type="radio" id="g-option" class="circle-2"--}}
{{--                                                        onclick="checkVnpay()" style="height: 18px;width: 20px;cursor: pointer"--}}
{{--                                                        value="1" name="payment_type">--}}
{{--                                                    <label--}}
{{--                                                        class="pay-text"> <img style="width: 20%;"--}}
{{--                                                        src="https://vnpay.vn/_nuxt/img/logo-primary.55e9c8c.svg" />--}}
{{--                                                        Thanh toán băng VNPAY--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
                                            </div>
                                            <div class="order_button">
                                                <a onclick="deleteCategories()" id="order_btn" >Thanh toán</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <span style="font-size: 20px " >Vui lòng <a style="color: #FF723A;font-weight: 700;" href="{{route('user.login')}}">Đăng nhập</a> hoặc
                        <a style="color: #FF723A;font-weight: 700;" href="{{route('user.register')}}">Đăng kí</a> để mua khóa học này!
                    </span>
                @endif
            @endif
        </div>
    </div>
</section>
@endsection
@section('script')
    <script src="/admin/dist/assets/js/sweetalert2/sweetalert2@11.js"> </script>
    <script src="/admin/dist/assets/js/toastr/toastr.min.js" ></script>
    <script src="/user/assets/js/courses/data.js" ></script>
@endsection
