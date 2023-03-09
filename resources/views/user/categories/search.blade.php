@extends('user.layouts.master')
@section('css')
    <link rel="stylesheet" href="/user/assets/css/home/style.css">
@endsection
@section ('title')
    Danh sách khóa học
@endsection
@section ('content')
    <section class="feature-course gradient-bg pt-150 pb-120 pt-md-95 pb-md-75 pt-xs-95 pb-xs-70">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section-title text-center mb-30">
                        <h4>Danh sách tất cả các khóa học:{{$name}}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-12 text-center">
                </div>
            </div>
            <div class="grid row">
                @if(count($courses) == 0)
                    <h4 style="text-align: center;">không có dữ liệu</h4>
                @endif
                @if(!empty($courses))
                    @foreach($courses as $course)
                        @if($course->status == \App\Models\Course::STATUS_PUBLISHED)
                            <div class="col-lg-4 col-md-6 grid-item">
                                <div class="z-gallery z-gallery-two gallery-03 mb-30">
                                    <div class="z-gallery__thumb mb-20">
                                        @if($course->check == \App\Models\Order::CONFIRM)
                                            <a style="cursor: pointer"
                                                href="{{ route('purchased_courses.get-course',['id' => $course->id])  }}">
                                                <img class="img-fluid img-course"
                                                     src="{{url(Storage::url($course->image))}}" alt="">
                                            </a>
                                        @else
                                            <a
                                                @if(empty(Auth::user()))
                                                    href="{{ route('courses.details',['id' => $course->id])}}"
                                                @endif
                                                @if(!empty(Auth::user()))
                                                    @if($course->check === null || $course->check == \App\Models\Order::CANCEL)
                                                        href="{{ route('courses.details',['id' => $course->id])}}"
                                                @elseif(($course->check == \App\Models\Order::CONFIRM))
                                                @elseif(($course->check == \App\Models\Order::WAIT))
                                                    href="{{ route('courses.details',['id' => $course->id])}}"
                                                @endif
                                                @else
                                                    style="cursor: pointer"
                                                @endif>
                                                <img class="img-fluid img-course"
                                                     src="{{url(Storage::url($course->image))}}" alt="">
                                            </a>
                                        @endif
                                        @if($course->type == \App\Models\Course::TYPE_LIVE)
                                            <div style="background-color: red" class="feedback-tag">
                                                <span>Skype</span>
                                            </div>
                                        @elseif($course->type == \App\Models\Course::TYPE_ONDEMAND)
                                            <div class="feedback-tag">
                                                <span>Video</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="z-gallery__content pos-rel">
                                        @if($course->check == \App\Models\Order::CONFIRM)
                                            <h4 class="sub-title text-show text-show mb-20"
                                                style="
                                                        white-space: nowrap !important;
                                                        overflow: hidden !important;
                                                        text-overflow: ellipsis !important;
                                                    ">
                                                <a href="{{ route('purchased_courses.get-course',['id' => $course->id])  }}">
                                                    {{$course->name}}
                                                </a>
                                            </h4>
                                        @else
                                            <h4 class="sub-title text-show mb-20"
                                                style="
                                                    white-space: nowrap !important;
                                                    overflow: hidden !important;
                                                    text-overflow: ellipsis !important;
                                                ">
                                                <a
                                                    @if(empty(Auth::user()))
                                                        href="{{ route('courses.details',['id' => $course->id])}}"
                                                    @endif
                                                    @if(!empty(Auth::user()))
                                                        @if($course->check === null ||
                                                            $course->check == \App\Models\Order::CANCEL)
                                                            href="{{ route('courses.details',['id' => $course->id])}}"
                                                    @elseif(($course->check == \App\Models\Order::CONFIRM))
                                                    @elseif(($course->check == \App\Models\Order::WAIT))
                                                        href="{{ route('courses.details',['id' => $course->id])}}"
                                                    @endif
                                                    @else
                                                        style="cursor: pointer"
                                                    @endif>
                                                    {{$course->name}}
                                                </a>
                                            </h4>
                                        @endif
                                        <div class="course__meta" style="padding-top: 20px" >
                                            <h5>
                                                <b style="color: rgb(4, 206, 158);font-size: 20px;" class="sub-title">
                                                    {{number_format($course->price,0,'.',',')}}đ
                                                </b>
                                            </h5>
                                            <span style=" color: #FF723A;font-weight: 600;" >GV:{{$course->staff->name}}</span>
                                        </div>
                                        <div style="margin-top: 20px;">
                                                <a class="btn-buy"
                                                   @if(empty(Auth::user()))
                                                       href="{{ route('courses.details',['id' => $course->id])}}"
                                                   @endif
                                                   @if(!empty(Auth::user()))
                                                       @if($course->check === null || $course->check == \App\Models\Order::CANCEL)
                                                           href="{{ route('courses.details',['id' => $course->id])}}"
                                                   @elseif(($course->check == \App\Models\Order::CONFIRM) &&
                                                            ($course->check == \App\Models\Order::WAIT))
                                                   @endif
                                                   @else
                                                       style="cursor: pointer"
                                                    @endif>
                                                    @if($course->check === null)
                                                        Mua ngay
                                                    @elseif( $course->check == \App\Models\Order::CANCEL )
                                                        Mua ngay
                                                    @elseif($course->check == \App\Models\Order::CONFIRM )
                                                        Đã mua
                                                    @elseif($course->check == \App\Models\Order::WAIT )
                                                        Chờ xác nhận
                                                    @endif
                                                </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                @endif
            </div>
        </div>
    </section>
@endsection
@section ('script')
    <script src="/admin/dist/assets/js/sweetalert2/sweetalert2@11.js"> </script>
    <script src="/admin/dist/assets/js/toastr/toastr.min.js" ></script>
    <script src="/user/assets/js/home/data.js" ></script>
@endsection
