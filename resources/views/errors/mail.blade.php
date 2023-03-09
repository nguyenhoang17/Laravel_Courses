@extends('user.layouts.master')
@section ('title')
Quên mật khẩu
@endsection
@section ('content')
    <main>
        <!--page-title-area start-->
         <section class="page-title-area d-flex align-items-end" style="background-image: url('https://images.unsplash.com/photo-1518655048521-f130df041f66?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8d29yayUyMGRlc2t8ZW58MHx8MHx8&w=1000&q=80');">
             <div class="container">
                 <div class="row align-items-end">
                     <div class="col-lg-12">
                         <div class="page-title-wrapper mb-50">
                        <h1 class="page-title mb-25">Quên mật khẩu </h1>
                            <div class="breadcrumb-list">
                               <ul class="breadcrumb">
                                   <li><a href="index.html">Trang chủ - </a></li>
                                       <li><a href="#">&nbsp;Quên mật khẩu</a></li>
                               </ul>
                            </div>
                       </div>
                     </div>
                 </div>
             </div>
         </section>
         <!--page-title-area end-->
         <!--contact-form-area start-->
         <section class="contact-form-area pt-150 pb-120 pt-md-100 pt-xs-100 pb-md-70 pb-xs-70">
             <div class="container">
                 <div class="row justify-content-center align-items-center">
                     <div class="col-lg-6">
                       <div class="contact-form-wrapper text-center mb-30">
                           <h2 class="mb-45">Nhập mật khẩu mới</h2>
                           <h3>Yêu cầu đã hết hạn, vui lòng gửi lại yêu cầu mới <a style="color: #ff723a" href="{{ route('user.forgot-password') }}">tại đây</a>.</h3>
                       </div>   
                     </div>
                 </div>
             </div>
         </section>
         <!--contact-form-area end-->
    </main>
@endsection
@section ('script')
    @error('login')
        <script>
            toastr.error("{{$message}}");
        </script>
    @enderror
@endsection
