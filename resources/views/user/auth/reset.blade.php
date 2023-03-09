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
                           <form action="{{ route('user.reset-password.check') }}" class="row gx-3 comments-form contact-form" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="col-lg-12 mb-30">
                                    <input type="text" readonly name="email" class="form-control" id="email" placeholder="Nhập email..." value="{{ $email->email }}">
                                </div>
                                <div class="col-lg-12 mb-30">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Nhập mật khẩu mới..." value="{{ old('password') }}">
                                    @error('password')
                                        <div class="text-danger" style="text-align: left !important; font-size:14px;">
                                            {{ $message }}
                                        </div>
                                    @enderror        
                                </div>
                                <div class="col-lg-12 mb-30">
                                    <input type="password" name="re_password" class="form-control @error('re_password') is-invalid @enderror" id="re_password" placeholder="Xác nhận lại mật khẩu..." value="{{ old('re_password') }}">
                                    @error('re_password')
                                        <div class="text-danger" style="text-align: left !important; font-size:14px;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                               </div>
                               <button class="theme_btn message_btn mt-20">Xác nhận</button>
                           </form>
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
