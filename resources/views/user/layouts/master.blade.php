<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="keywords" content="online education, e-learning, coaching, education, teaching, learning">
    <meta name="description" content="Zoomy is a e-learnibg HTML template for all kinds of education, coaching, online education website">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="/admin/dist/assets/media/logos/icon-zent.png">
    <!-- Place favicon.ico in the root directory -->
    <script src="/user/assets/js/font-awesome/all.min.js"></script>
    <!-- CSS here -->
    <link rel="stylesheet" href="/user/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/user/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/user/assets/css/animate.css">
    <link rel="stylesheet" href="/user/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="/user/assets/css/all.min.css">
    <link rel="stylesheet" href="/user/assets/css/flaticon.css">
    <link rel="stylesheet" href="/user/assets/css/font.css">
    <link rel="stylesheet" href="/user/assets/css/metisMenu.css">
    <link rel="stylesheet" href="user/assets/css/nice-select.css">
    <link rel="stylesheet" href="/user/assets/css/slick.css">
    <link rel="stylesheet" href="/user/assets/css/spacing.css">
    <link rel="stylesheet" href="/user/assets/css/main.css">
    <link media="screen" rel="stylesheet" type="text/css" href="/user/assets/css/toastr.css"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/admin/dist/assets/js/toastr/toastr.min.js">
    @yield('css')
</head>
<body>
    <!-- HEADER -->
    @include('user.include.header')
    @include('user.include.menu-mobile')
    <!-- CONTENT -->
    <aside class="slide-bar">
      <div class="close-mobile-menu">
          <a href="javascript:void(0);"><i class="fas fa-times"></i></a>
      </div>

      <!-- offset-sidebar start -->
      <div class="offset-sidebar">
          <div class="offset-widget offset-logo mb-30">
              <a href="index.html">
                  <img
                      src="/user/user/assets/img/logo/header_logo_one.svg"
                      alt="logo"
                  />
              </a>
          </div>
          <div class="offset-widget mb-40">
              <div class="info-widget">
                  <h4 class="offset-title mb-20">About Us</h4>
                  <p class="mb-30">
                      But I must explain to you how all this mistaken idea of
                      denouncing pleasure and praising pain was born and will give
                      you a complete account of the system and expound the actual
                      teachings of the great explore
                  </p>
                  <a class="theme_btn theme_btn_bg" href="contact.html"
                      >Contact Us</a
                  >
              </div>
          </div>
          <div class="offset-widget mb-30 pr-10">
              <div class="info-widget info-widget2">
                  <h4 class="offset-title mb-20">Contact Info</h4>
                  <p>
                      <i class="fal fa-address-book"></i> 23/A, Miranda City
                      Likaoli Prikano, Dope
                  </p>
                  <p><i class="fal fa-phone"></i> +0989 7876 9865 9</p>
                  <p><i class="fal fa-envelope-open"></i> info@example.com</p>
              </div>
          </div>
      </div>
      <!-- offset-sidebar end -->

      <!-- side-mobile-menu start -->
      <nav class="side-mobile-menu">
          <ul id="mobile-menu-active">
              <li class="has-dropdown">
                  <a href="index.html">Home</a>
                  <ul class="sub-menu">
                      <li><a href="index.html">Home Style 1</a></li>
                      <li><a href="index-2.html">Home Style 2</a></li>
                      <li><a href="index-3.html">Home Style 3</a></li>
                  </ul>
              </li>
              <li><a href="about.html">About</a></li>
              <li class="has-dropdown">
                  <a href="#">Pages</a>
                  <ul class="sub-menu">
                      <li><a href="courses.html">Course One</a></li>
                      <li><a href="courses-2.html">Course Two</a></li>
                      <li><a href="course-details.html">Courses Details</a></li>
                      <li><a href="price.html">Price</a></li>
                      <li><a href="instructor.html">Instructor</a></li>
                      <li>
                          <a href="instructor-profile.html">Instructor Profile</a>
                      </li>
                      <li><a href="faq.html">FAQ</a></li>
                      <li><a href="login.html">login</a></li>
                  </ul>
              </li>
              <li class="has-dropdown">
                  <a href="#">Blogs</a>
                  <ul class="sub-menu">
                      <li><a href="blog.html">Blog Grid</a></li>
                      <li><a href="blog-details.html">Blog Details</a></li>
                  </ul>
              </li>
              <li><a href="contact.html">Contacts Us</a></li>
          </ul>
      </nav>
      <!-- side-mobile-menu end -->
    </aside>
    <div class="body-overlay"></div>
    @yield('content')
    <!-- FOOTER -->
    @include('user.include.footer')

  <!-- JS here -->
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
    <script type="text/javascript" src="/user/assets/js/toastr.js"></script>
    @yield('script')
    @if(Session::has('success'))
        <script>
            toastr.success("{!! session()->get('success') !!}");
        </script>
    @elseif(Session::has('error'))
        <script>
            toastr.error("{!! session()->get('error') !!}");
        </script>
    @endif
</body>
</html>
