
<!-- Add your site or application content here -->
    <header>
        <div id="theme-menu-two" class="main-header-area main-head-three pl-100 pr-100 pt-20 pb-15">
            <div class="container-fluid">
                <div class="row align-items-center">
                        <div class="col-xl-2">
                            <div class="logo"><a href="{{route('home')}}"><img src="https://zent.edu.vn/zent_logo_dark.png" alt=""></a></div>
                        </div>
                        <div class="col-xl-7">
                            <nav class="main-menu navbar navbar-expand-lg justify-content-center">
                                <div class="nav-container">
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav">
                                            <li>
                                                <a style="
                                                    color: #505050;
                                                    font-size: 20px;
                                                    line-height: 1;
                                                    display: inline-block;
                                                    position: relative;
                                                    margin: 0 37px;
                                                    padding: 30px 0;
                                                " href="{{route('home')}}" id="navbarDropdown5" role="button" aria-expanded="false">Trang chủ</a>
                                            </li>
                                            <li class="nav-item dropdown mega-menu">
                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Tất cả danh mục
                                                </a>
                                                <ul class="dropdown-menu submenu mega-menu__sub-menu-box" aria-labelledby="navbarDropdown">
                                                    @if(!empty($categories))
                                                        @foreach($categories as $category)
                                                            <li><a href="{{route('categories.index',['id' => $category->id])}}"><span><img src="/user/assets/img/icon/icon8.svg" alt=""></span><b>{{ $category->name }}</b></a></li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </li>
                                            <li class="nav-item dropdown mega-menu">
                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Thẻ
                                                </a>
                                                <ul class="dropdown-menu submenu mega-menu__sub-menu-box" aria-labelledby="navbarDropdown">
                                                    @if(!empty($tags))
                                                        @foreach($tags as $tag)
                                                            <li><a href="{{route('categories.searchTag',['id' => $tag->id])}}"><span><img src="/user/assets/img/icon/icon14.svg" alt=""></span><b>{{$tag->name}}</b></a></li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </li>

                                            <li class="nav-item">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <div class="col-xl-3 col-lg-2 col-7">
                            @guest
                                <div class="right-nav d-flex align-items-center justify-content-end">
                                    @if (!(request()->routeIs('user.register')))
                                        <div class="right-btn" style="margin-right:20px;">
                                            <ul class="d-flex align-items-center">
                                                <li><a href="{{ route('user.register') }}" class="theme_btn free_btn">Đăng ký</a></li>
                                            </ul>
                                        </div>
                                    @endif
                                    @if (!(request()->routeIs('user.login')))
                                        <div class="right-btn">
                                            <ul class="d-flex align-items-center">
                                                <li><a href="{{ route('user.login') }}" class="theme_btn free_btn">Đăng nhập</a></li>
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="hamburger-menu d-md-inline-block d-lg-none text-right">
                                        <a href="javascript:void(0);">
                                            <i class="far fa-bars"></i>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div>
                                    <nav class="main-menu navbar navbar-expand-lg justify-content-center">
                                        <div class="nav-container">
                                            <div class="collapse navbar-collapse">
                                                <ul class="navbar-nav">
                                                    <li class="nav-item dropdown" >
                                                        <a class="sign-in ml-20" href="#"><img src="/user/assets/img/icon/user.svg" alt=""></a>
                                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown4">
                                                            <li><a class="dropdown-item" href="{{ route('settings.edit',Auth::guard('web')->user()->id) }}">Thông tin tài khoản</a></li>
                                                            <li><a class="dropdown-item" href="{{ route('purchased_courses.index') }}">Khoá học đã mua</a></li>
                                                            <li><a class="dropdown-item" href="{{ route('user.logout') }}">Đăng xuất</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                    <div class="hamburger-menu d-md-inline-block d-lg-none text-right">
                                        <a href="javascript:void(0);">
                                            <i class="far fa-bars"></i>
                                        </a>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.theme-main-menu -->
    </header>

