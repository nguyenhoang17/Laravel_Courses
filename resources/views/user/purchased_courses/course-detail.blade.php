@extends('user.layouts.master')
@section ('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/user/assets/css/chat/emojionearea.min.css">
    <link rel="stylesheet" href="/user/assets/css/chat/chat.css">
@endsection
@section ('title')
    {{$course->name}}
@endsection
@section ('content')
<section class="page-title-area d-flex align-items-end" style="background-image: url('{{url(\Illuminate\Support\Facades\Storage::url($course->image))}}'); height: 400px">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-title-wrapper mb-50">
                    <h1 class="page-title mb-25">{{$course->name}}</h1>
                    <div class="breadcrumb-list">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">Trang chủ -</a></li>
                            <li><a href="{{route('purchased_courses.index')}}"> Khoá học đã mua - </a></li>
                            <li><a href="#"> {{$course->name}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if($course->type===\App\Models\Course::TYPE_LIVE)
<div class="main-slider" id="course-live">
    <div class="container">
        <p class="title-description">Thời gian bắt đầu dự kiến: {{date("H:i | d/m/Y",$course->start_time)}}</p>
        <p class="title-description">Giảng viên: {{$course->staff->name}}</p>
        <p><span class="title-description">Mô tả:</span> {{$course->description}}</p>
        <p><span class="title-description">Link Skype:</span> <a href="{{$course->key}}">{{$course->key}}</a></p>
    </div>
    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col-4" style="max-height: 400px; overflow-y: scroll" id="scroll15">
                <h4>Danh sách bài học:</h4>
                <ul>
                    @foreach($status_course->units as $unit)
                        <li style="  padding: 20px;border-bottom: 1px solid #ccc;"><a href="{{route('purchased_courses.unit',['course_id'=>$status_course->id, 'id'=>$unit->id])}}">{{$unit->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <style>
                #scroll15::-webkit-scrollbar-track
                {
                    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1) !important;
                    background-color: #F5F5F5 !important;
                    border-radius: 10px !important;
                }

                #scroll15::-webkit-scrollbar
                {
                    width: 10px !important;
                    background-color: #F5F5F5 !important;
                }

                #scroll15::-webkit-scrollbar-thumb
                {
                    border-radius: 10px !important;
                    background-color: #FFF;
                    background-image: -webkit-linear-gradient(top,
                    #e4f5fc 0%,
                    #bfe8f9 50%,
                    #9fd8ef 51%,
                    #2ab0ed 100%) !important;
                }

            </style>
        </div>

    </div>
    @if($course->is_live==\App\Models\OrderDetail::STATUS['LIVING'] && $status_course->start_live==\App\Models\Course::START_LIVE)
    <div class="content">
        @php
            $staff_id = 0;
            $user_id = 0;
            $guard = false;
                if (\Illuminate\Support\Facades\Auth::guard('admin')->id()){
                    $staff_id = \Illuminate\Support\Facades\Auth::guard('admin')->id();
                }else if(\Illuminate\Support\Facades\Auth::guard('web')->id()){
                    $user_id = \Illuminate\Support\Facades\Auth::guard('web')->id();
                    $guard = true;
                }
        @endphp
        <div class="live-wrap">
            <div class="live">
                <video id="video" width="100%" height="100%" controls></video>
            </div>
        </div>
        <div class="chat-wrap">
            <h2 class="title-chat">Real time chat</h2>
                <div id="messages" class="chat-content">
                    @if(count($messages)>0)
                        @foreach($messages as $message)
                            @if(($user_id && $user_id===$message->user_id) || ($staff_id && $staff_id===$message->staff_id))
                                <p class="message-auth content-message">
                                    <span class="message">{{$message->message}}</span>
                                </p>
                            @else
                                <p class="message-other content-message">
                                    @if($message->user)
                                        <span class="author" style="font-weight: bold">{{$message->user->name}}</span>
                                    @elseif($message->staff)
                                        <span class="author" style="font-weight: bold">{{$message->staff->name}}</span>
                                    @endif
                                    <span class="message">{{$message->message}}</span>
                                </p>
                            @endif
                        @endforeach
                    @endif
                </div>
            <div class="chat-input">
                <textarea rows="4" style="height: 100%!important;"  type="text" class="form-control form-control-flush" placeholder="Nhập tin nhắn..." name="message" id="message">
                </textarea>
                <input type="text" name="live_key" placeholder="course_id" id="course_id" value="{{$course->order->course_id}}" hidden>
                <input type="text" name="live_key" placeholder="live_key" id="live_key" value="{{$course->key}}" hidden>
                <input type="text" name="user_id" placeholder="user_id" id="user_id" value="{{$user_id}}" hidden>
                <input type="text" name="staff_id" placeholder="staff_id" id="staff_id" value="{{$staff_id}}" hidden>
                <input type="text" name="guard" placeholder="guard" id="guard" value="{{$guard}}" hidden>
                <button id="send" data-toggle="tooltip" data-placement="top" title="Gửi">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
    @endif
    <div class="description-course">
        @if(count($files)>0)
            <p class="title-description">Tài liệu khoá học: </p>
            @foreach($files as $file)
                <div class="row justify-content-center" style="width: 100%;margin: 0 auto">
                    <iframe src="{{url(\Illuminate\Support\Facades\Storage::url($file->path))}}" width="50%" height="1000" style="padding: 0">
                        This browser does not support PDFs. Please download the PDF to view it: <a href="{{url(\Illuminate\Support\Facades\Storage::url($file->path))}}">Download PDF</a>
                    </iframe>
                </div>
            @endforeach
        @endif
    </div>
</div>
@else
<div class="main-slider" id="course-one">
    <div class="description-course">
        <div class="container">
            <p class="title-description">Giảng viên: {{$course->staff->name}}</p>
            <p><span class="title-description">Mô tả:</span> {{$course->description}}</p>
        </div>
    </div>
    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col-4" style="max-height: 400px; overflow-y: scroll" id="scroll16">
                <h4>Danh sách bài học:</h4>
                <ul>
                    @foreach($status_course->units as $unit)
                        <li style="  padding: 20px;border-bottom: 1px solid #ccc;"><a href="{{route('purchased_courses.unit',['course_id'=>$status_course->id, 'id'=>$unit->id])}}">{{$unit->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <style>
                #scroll16::-webkit-scrollbar-track
                {
                    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1) !important;
                    background-color: #F5F5F5 !important;
                    border-radius: 10px !important;
                }

                #scroll16::-webkit-scrollbar
                {
                    width: 10px !important;
                    background-color: #F5F5F5 !important;
                }

                #scroll16::-webkit-scrollbar-thumb
                {
                    border-radius: 10px !important;
                    background-color: #FFF;
                    background-image: -webkit-linear-gradient(top,
                    #e4f5fc 0%,
                    #bfe8f9 50%,
                    #9fd8ef 51%,
                    #2ab0ed 100%) !important;
                }

            </style>
        </div>

    </div>
</div>

@endif
@endsection
@section ('script')
    <script id="chat-message-other" type="text/template">
        <p class="message-other content-message">
            <span class="author" style="font-weight: bold"></span>
            <span class="message message-auth"></span>
        </p>
    </script>
    <script id="chat-message-auth" type="text/template">
        <p class="message-auth content-message">
            <span class="message"></span>
        </p>
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.1/pusher.min.js"></script>
    <script type="text/javascript" src="/user/assets/js/chat/emojionearea.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script type="text/javascript" src="/user/assets/js/chat/chat.js"></script>
    <script type="text/javascript" src="/user/assets/js/chat/live.js"></script>
@endsection
