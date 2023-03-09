@extends('user.layouts.master')
@section ('title')
    Trang chủ
@endsection
@section ('css')
    <link rel="stylesheet" href="/user/assets/css/home/style.css">
@endsection
@section ('content')
<section class="slider-area pt-180 pt-xs-150 pt-150 pb-xs-35">
   <img class="sl-shape shape_01" src="/user/assets/img/icon/01.svg" alt="">
   <img class="sl-shape shape_02" src="/user/assets/img/icon/02.svg" alt="">
   <img class="sl-shape shape_03" src="/user/assets/img/icon/03.svg" alt="">
   <img class="sl-shape shape_04" src="/user/assets/img/icon/04.svg" alt="">
   <img class="sl-shape shape_05" src="/user/assets/img/icon/05.svg" alt="">
   <img class="sl-shape shape_06" src="/user/assets/img/icon/06.svg" alt="">
   <img class="sl-shape shape_07" src="/user/assets/img/shape/dot-box-5.svg" alt="">
   <div class="main-slider pt-10">
       <div class="container">
           <div class="row align-items-center">
               <div class="col-xl-6 col-lg-6 order-last order-lg-first">
                   <div class="slider__img__box mb-50 pr-30">
                       <img class="img-one mt-55 pr-70" src="https://html.creativegigstf.com/zoomy/assets/img/slider/01.png" alt="">
                       <img class="slide-shape img-two" src="https://html.creativegigstf.com/zoomy/assets/img/slider/02.png" alt="">
                       <img class="slide-shape img-three" src="https://html.creativegigstf.com/zoomy/assets/img/slider/03.png" alt="">
                       <img class="slide-shape img-four" src="https://html.creativegigstf.com/zoomy/assets/img/shape/dot-box-1.svg" alt="">
                       <img class="slide-shape img-five" src="https://html.creativegigstf.com/zoomy/assets/img/shape/zigzg-1.svg" alt="">
                       <img class="slide-shape img-six" src="https://html.creativegigstf.com/zoomy/assets/img/icon/dot-plan-1.svg" alt="">
                       <img class="slide-shape img-seven wow fadeInRight animated" data-delay="1.5s" src="https://html.creativegigstf.com/zoomy/assets/img/icon/dot-plan-1.svg" alt="Chose-img">
                       <img class="slide-shape img-eight" src="https://html.creativegigstf.com/zoomy/assets/img/slider/earth-bg.svg" alt="">
                   </div>
               </div>
               <div class="col-xl-6 col-lg-6">
                   <div class="slider__content pt-15">
                       <h1 class="main-title mb-40 wow fadeInUp2 animated"
                           data-wow-delay='.1s'>Tìm hiểu hàng ngày với các kỹ năng mới trực tuyến với các giảng viên
                           <span class="vec-shape"> hàng đầu.</span>
                       </h1>
                       <form class="input-form" action="{{route('categories.searchCategory')}}">

                           <ul class="search__area d-md-inline-flex align-items-center justify-content-between mb-30">
                               <li>
                                   <div class="widget__search">
                                       <input style="
                                       border: 0 !important;
                                        color: #707070 !important;
                                        background: transparent !important;
                                        border-radius: 0 !important;
                                        border-top-left-radius: 40px !important;
                                        border-bottom-left-radius: 40px !important;
                                        display: inline-block !important;
                                        position: relative !important;
                                        height: 65px !important;
                                        padding-left: 55px !important;
                                        width: 100% !important;
                                        z-index: 1 !important;
                                       " name="name"  type="text" placeholder="Tìm kiếm khóa học">
                                       <button class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></button>
                                   </div>
                               </li>
                               <li>
                                   <div class="widget__select">

                                   </div>
                               </li>
                               <li>
                                   <button style="padding: 24px 54px ;" type="submit" class="theme_btn search_btn ml-35">
                                       Tìm kiếm
                                   </button>
                               </li>
                           </ul>
                       </form>
                       <p class="highlight-text"><span>#1</span> Nền tảng phát triển kỹ năng và học tập trực tuyến trên toàn thế giới</p>
                   </div>
               </div>
           </div>
       </div>
   </div>
</section>
<section class=" pt-150 pb-130 pt-md-95 pb-md-80 pt-xs-95 pb-xs-80">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-title text-center mb-50">
                    @if(count($courses_highlight) > 0)
                        <h2>Khóa học nổi bật</h2>
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 text-center">
                <div class="portfolio-menu mb-30">
                </div>
            </div>
        </div>
        <div class="grid row">
            @if(!empty($courses_highlight))
                @foreach($courses_highlight as $course)
                    @if($course->status == \App\Models\Course::STATUS_PUBLISHED)
                        <div class="col-lg-4 col-md-6 grid-item">
                            <div class="z-gallery z-gallery-two gallery-03 mb-30">
                                <div class="z-gallery__thumb mb-20">
                                    @if($course->check == \App\Models\Order::CONFIRM)
                                        <a style="cursor: pointer"
                                           href="{{ route('purchased_courses.get-course',['id' => $course->id])  }}"
                                        >
                                            <img class="img-fluid img-course"
                                                 src="{{url(Storage::url($course->image))}}" alt="">
                                        </a>
                                    @else
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
                                            @endif
                                        ><img class="img-fluid img-course" src="{{url(Storage::url($course->image))}}" alt="">
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
                                        @if(empty(Auth::user()))
                                            <a class="btn-buy"  style="cursor: pointer"
                                               href="{{ route('courses.details',['id' => $course->id])}}"
                                            >
                                                Mua ngay
                                            </a>
                                        @else
                                            <a class="btn-buy"
                                               @if(empty(Auth::user()))
                                                   href="{{ route('courses.details',['id' => $course->id])}}"
                                               @endif
                                               @if(!empty(Auth::user()))
                                                   @if($course->check === null ||
                                                        $course->check == \App\Models\Order::CANCEL)
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
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</section>
<section>
@if(!empty($categories))
    @foreach($categories as $category)
        @if(count($category->courses) > 0 )
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="category">
                            <h2>
                                <span class="category-name" >
                                    {{$category->name}}
                                </span>
                                <span class="categoty-all">
                                    <a  href="{{route('categories.index',['id' => $category->id])}}">Xem tất cả</a>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </span>
                            </h2>
                        </div>
                    </div>
                </div>
                    <div class="grid row">
                        @foreach($category->courses as $course)
                        @if($course->status == \App\Models\Course::STATUS_PUBLISHED )
                                <div class="col-lg-4 col-md-6 grid-item cat2 cat3">
                                    <div class="z-gallery mb-30">
                                        <div class="z-gallery__thumb mb-20">
                                            <a
                                                @if(empty(Auth::user()))
                                                    href="{{ route('courses.details',['id' => $course->id])}}"
                                                @endif
                                                @if(!empty(Auth::user()))
                                                    @if($course->check === null ||
                                                        $course->check == \App\Models\Order::CANCEL)
                                                        href="{{ route('courses.details',['id' => $course->id])}}"
                                                    @elseif(($course->check == \App\Models\Order::CONFIRM))
                                                        href="{{ route('purchased_courses.get-course',['id' => $course->id])  }}"
                                                    @elseif(($course->check == \App\Models\Order::WAIT))
                                                        href="{{ route('courses.details',['id' => $course->id])}}"
                                                @endif
                                                @else
                                                    style="cursor: pointer"
                                                @endif>
                                                <img class="img-fluid img-course"
                                                     src="{{url(Storage::url($course->image))}}" alt=""></a>
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
                                        <div class="z-gallery__content">
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
                                                <span>GV:{{$course->staff->name}}</span>
                                            </div>
                                            <div style="margin-top: 20px;">
                                                    <a class="btn-buy"
                                                       @if(empty(Auth::user()))
                                                           href="{{ route('courses.details',['id' => $course->id])}}"
                                                       @endif
                                                       @if(!empty(Auth::user()))
                                                            @if($course->check === null ||
                                                                $course->check == \App\Models\Order::CANCEL)
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
                    </div>
            </div>
        @endif
    @endforeach
@endif
</section>
@endsection
@section ('script')
<script src="/admin/dist/assets/js/sweetalert2/sweetalert2@11.js"> </script>
<script src="/admin/dist/assets/js/toastr/toastr.min.js" ></script>
<script src="/user/assets/js/home/data.js" ></script>
@endsection
