<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live</title>
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="/user/assets/img/favicon.png">
    <link rel="stylesheet" href="/user/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/user/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/user/assets/css/animate.css">
    <link rel="stylesheet" href="/user/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="/user/assets/css/all.min.css">
    <link rel="stylesheet" href="/user/assets/css/flaticon.css">
    <link rel="stylesheet" href="/user/assets/css/font.css">
    <link rel="stylesheet" href="/user/assets/css/metisMenu.css">
    <link rel="stylesheet" href="/user/assets/css/nice-select.css">
    <link rel="stylesheet" href="/user/assets/css/slick.css">
    <link rel="stylesheet" href="/user/assets/css/spacing.css">
    <link rel="stylesheet" href="/user/assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/user/assets/css/chat/emojionearea.min.css">
    <link rel="stylesheet" href="/user/assets/css/chat/chat.css">
</head>
<body>
    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="body-overlay"></div>
    <main>
        <section class="slider-area slider-gradient-bg pt-30 pb-30 pb-xs-50">
            <img class="sl-shape shape_01" src="/user/assets/img/icon/01.svg" alt="">
            <img class="sl-shape shape_02" src="/user/assets/img/icon/02.svg" alt="">
            <img class="sl-shape shape_03" src="/user/assets/img/icon/03.svg" alt="">
            <img class="sl-shape shape_04" src="/user/assets/img/icon/04.svg" alt="">
            <img class="sl-shape shape_05" src="/user/assets/img/icon/05.svg" alt="">
            <img class="sl-shape shape_06" src="/user/assets/img/icon/06.svg" alt="">
            <div class="main-slider">
                <div class="container">
                    @php
                    $staff_id = 0;
                    $user_id = 0;
                        if (\Illuminate\Support\Facades\Auth::guard('admin')->id()){
                            $staff_id = \Illuminate\Support\Facades\Auth::guard('admin')->id();
                        }else if(\Illuminate\Support\Facades\Auth::guard('web')->id()){
                            $user_id = \Illuminate\Support\Facades\Auth::guard('web')->id();
                        }
                    @endphp
                    <div class="live-wrap">
                        <div class="live">
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/7vz65wrPeBM" title="🔴 Tin Tức Đặc Biệt Đừng Bỏ Lỡ  Trưa 21/6 | Tin Tức Thời Sự Mới nhất, Chính Xác Nhất | ON TV" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <h2 class="title-course">{{$course->name}}</h2>
                        <p class="description-course">
                            <span>
                            Bắt đầu phát trực tiếp 5 giờ trước |
                            </span>
                            <span>
                            {{$course->description}}
                            </span>
                        </p>
                        <p class="description-course">
                            Giảng viên: {{$course->staff->name}}
                        </p>
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
                            <textarea rows="4" style="height: 100%!important;"  type="text" class="form-control form-control-flush" placeholder="Nhập tin nhắn..." name="message" id="message"></textarea>
                            <input type="text" name="live_key" placeholder="live_key" id="live_key" value="2" hidden>
                            <input type="text" name="user_id" placeholder="user_id" id="user_id" value="{{$user_id}}" hidden>
                            <button id="send" data-toggle="tooltip" data-placement="top" title="Gửi">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
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
    <script src="/user/assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="/user/assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="/user/assets/js/popper.min.js"></script>
    <script src="/user/assets/js/bootstrap.min.js"></script>
    <script src="/user/assets/js/owl.carousel.min.js"></script>
    <script src="/user/assets/js/isotope.pkgd.min.js"></script>
    <script src="/user/assets/js/slick.min.js"></script>
    <script src="/user/assets/js/metisMenu.min.js"></script>
    <script src="/user/assets/js/jquery.nice-select.js"></script>
    <script src="/user/assets/js/ajax-form.js"></script>
    <script src="/user/assets/js/wow.min.js"></script>
    <script src="/user/assets/js/jquery.counterup.min.js"></script>
    <script src="/user/assets/js/waypoints.min.js"></script>
    <script src="/user/assets/js/jquery.scrollUp.min.js"></script>
    <script src="/user/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="/user/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/user/assets/js/jquery.easypiechart.js"></script>
    <script src="/user/assets/js/plugins.js"></script>
    <script src="/user/assets/js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.1/pusher.min.js"></script>
    <script type="text/javascript" src="/user/assets/js/chat/emojionearea.min.js"></script>
    <script type="text/javascript" src="/user/assets/js/chat/chat.js"></script>
</body>
</html>
