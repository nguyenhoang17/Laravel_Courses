<footer class="footer-area pt-70 pb-40">
        <div class="container">
            <div class="row mb-15">
                <div class="col-xl-3 col-lg-4 col-md-6  wow fadeInUp2 animated" data-wow-delay='.1s'>
                    <div class="footer__widget mb-30">
                        <div class="footer-log mb-20">
                            <a href="index.html" class="logo">
                                <img src="https://zent.edu.vn/zent_logo_dark.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp2 animated" data-wow-delay='.3s'>
                    <div class="footer__widget mb-30 pl-40 pl-md-0 pl-xs-0">
                        <h6 class="widget-title mb-35">Thông tin</h6>
                        <ul class="fot-list">
                            <li><a href="#"><b>Giờ hành chính:</b> 8h30 - 18h00 từ thứ 2 đến thứ 7 (trừ các ngày nghỉ lễ, tết)</a></li>
                            <li><a href="#"><b>Trụ sở chính:</b> Tầng 6, số 2 ngõ 118 Trương Định, Hai Bà Trưng, Hà Nội</a></li>
                            <li><a href="#"><b>Cơ sở 2:</b> Khoa CNTT - HV Nông nghiệp Việt Nam (Trâu Quỳ - Gia Lâm - Hà Nội)</a></li>
                            <li><a href="#"><b>Hotline:</b> <span style="color: #ff7300;font-weight: 800;">0868 901 456</span></a></li>
                            <li><a href=""><b>Email:</b><span style="color: #ff7300;font-weight: 800;">info@zent.vn</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6  wow fadeInUp2 animated" data-wow-delay='.5s'>
                    <div class="footer__widget mb-25 pl-90 pl-md-0 pl-xs-0">
                        <h6 class="widget-title mb-35">Danh mục</h6>
                        <ul class="fot-list">
                            @if(!empty($categories))
                                @foreach($categories as $category)
                                    <li><a href="{{route('categories.index',['id' => $category->id])}}">{{$category->name}}</a></li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6  wow fadeInUp2 animated" data-wow-delay='.7s'>
                    <div class="footer__widget mb-30 pl-50 pl-lg-0 pl-md-0 pl-xs-0">
                        <h6 class="widget-title mb-35">Liên hệ trực tuyến</h6>
                        <div class="social-media footer__social mt-30">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-google-plus-g"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right-area border-bot pt-40">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="copyright text-center">
                            <h5><span style="color: #ff7300;font-weight: 800;">Công ty Cổ phần Giáo dục Zent Education</span> - MST: 0108803958</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</footer>
