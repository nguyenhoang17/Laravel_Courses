@extends('user.layouts.master')
@section ('title')
    Khoá học đã mua
@endsection
@section ('content')
<main>
    <!--page-title-area start-->
     <section class="page-title-area d-flex align-items-end" style="background-image: url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80');">
         <div class="container">
             <div class="row align-items-end">
                 <div class="col-lg-12">
                     <div class="page-title-wrapper mb-50">
                        <h1 class="page-title mb-25">Khoá học đã mua</h1>
                        <div class="breadcrumb-list">
                           <ul class="breadcrumb">
                               <li><a href="{{route('home')}}">Trang chủ -</a></li>
                               <li><a href="#">&nbsp;Khoá học đã mua</a></li>
                           </ul>
                        </div>
                   </div>
                 </div>
             </div>
         </div>
     </section>
     <!--page-title-area end-->
     <!-- blog-area start -->
       <section class="blog-area">
           <div class="blog-bg pt-150 pb-120 pt-md-100 pb-md-70 pt-xs-100 pb-xs-70">
               <div class="container">
                   <div class="row justify-content-center">
                       <div class="col-lg-8">
                           <div class="section-title text-center mb-45">
                               <h2 class="mb-25">Danh sách khoá học đã mua</h2>
                           </div>
                       </div>
                   </div>
                   <div class="row align-items-center justify-content-center mb-25">
                       <div class="col-xl-6 col-lg-6">
                            <div class="slider__content">
                                <ul class="search__area d-md-inline-flex align-items-center justify-content-between mb-30">
                                    <li>
                                        <div class="widget__search">
                                            <div class="input-form" action="#">
                                                <input type="text" name="name" class="name" id="search" placeholder="Tìm kiếm khoá học">
                                            </div>
                                            <button class="search-icon"><i class="fa-solid fa-search"></i></button>
                                        </div>
                                    </li>
{{--                                    <li>--}}
{{--                                        <div class="widget__select" style="margin-left:50px;">--}}
{{--                                            <select name="category" id="select" class="nice-select" >--}}
{{--                                                <option value="">Tất cả danh mục</option>--}}
{{--                                                @if (!empty($categories))--}}
{{--                                                    @foreach ($categories as $category)--}}
{{--                                                        <option class="category" value="{{  $category->id  }}">{{ $category->name }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                @endif--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
                                    <li>
                                        <button class="theme_btn search_btn" id="search_data" style="margin-left:55px!important;">Tìm kiếm</button>
                                    </li>
                                </ul>
                            </div>
                       </div>
                   </div>
                   <div class="row" id="search_result">
                        @php
                            $count = 0;
                        @endphp
                        @foreach($order_detail as $my_course)
                            @php
                                $count++;
                            @endphp
                            @if($my_course->order->status == \App\Models\Order::STATUS['SUCCESS'] && $my_course->order->status !== \App\Models\Order::CANCEL && $my_course->order->status !== \App\Models\Order::WAIT && $my_course->order->user_id == Auth::guard('web')->user()->id)
                                <div class="col-lg-4 col-md-6 grid-item cat2 cat3">
                                    <div class="z-gallery mb-30">
                                        <div class="z-gallery__thumb mb-20">
                                            <a href="{{ route('purchased_courses.get-course',['id' => $my_course->order->course_id])  }}"><img class="img-fluid img-course" src="{{url(Storage::url($my_course->image))}}" alt=""></a>
                                            <div class="feedback-tag @if($my_course->type == \App\Models\OrderDetail::TYPE_LIVE) bg-danger @endif">{{ $my_course->type_view }}</div>
                                        </div>
                                        <div class="z-gallery__content">
                                            <h4 class="sub-title course-name"><a href="{{ route('purchased_courses.get-course',['id' => $my_course->order->course_id])  }}">{{$my_course->name}}</a></h4>
                                            <div class="course__meta">
                                                <h5>
                                                    <b style="color: rgb(84,205,236);font-size: 20px;" class="sub-title">GV: {{$my_course->staff->name}}</b>
                                                </h5>
                                                @if($my_course->type == \App\Models\OrderDetail::TYPE_LIVE)
                                                    <span>Bắt đầu lúc: {{date("H:i | d/m/Y",$my_course->start_time)}}</span>
                                                @else
                                                    <span>Video và học liệu</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if ($count == 0)
                            <h3 class="mb-25 text-center text-muted">Hiện bạn chưa mua khoá học nào, hãy ra trang chủ và mua gì đó :></h3>
                        @endif
                   </div>
               </div>
           </div>
       </section>

       <!-- blog-area end -->
</main>
@endsection
@section ('script')
    <script type="text/javascript" src="/user/assets/js/purchased_course/script.js"></script>
@endsection
