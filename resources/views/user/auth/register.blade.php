@extends('user.layouts.master')
@section ('title')
    Đăng kí
@endsection
@section ('content')
    <main>
        <!--page-title-area start-->
         <section class="page-title-area d-flex align-items-end" style="background-image: url('https://images.unsplash.com/photo-1518655048521-f130df041f66?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8d29yayUyMGRlc2t8ZW58MHx8MHx8&w=1000&q=80');">
             <div class="container">
                 <div class="row align-items-end">
                     <div class="col-lg-12">
                         <div class="page-title-wrapper mb-50">
                            <h1 class="page-title mb-25">Đăng ký thành viên</h1>
                            <div class="breadcrumb-list">
                               <ul class="breadcrumb">
                                   <li><a href="index.html">Trang chủ - </a></li>
                                   <li><a href="#">&nbsp;Đăng ký thành viên</a></li>
                               </ul>
                            </div>
                       </div>
                     </div>
                 </div>
             </div>
         </section>
         <!--page-title-area end-->
         <!--contact-form-area start-->
         <section class="contact-form-area pt-90 pb-120 pb-md-70 pb-xs-70">
             <div class="container">
                 <div class="row align-items-center">
                     <div class="col-lg-6">
                       <div class="contact-form-wrapper mb-30">
                           <h2 class="mb-45">Đăng Ký</h2>
                           <form action="{{ route('user.register.authenticate') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên đầy đủ<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger text-left" style="font-size:14px;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>

                                    </div>
                                    <input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger text-left" style="font-size:14px;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="password" class="form-label">Mật khẩu<span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control" id="password" value="{{ old('password') }}">
                                        @error('password')
                                            <div class="text-danger text-left" style="font-size:14px;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="password1" class="form-label">Nhập lại mật khẩu<span class="text-danger">*</span></label>
                                        <input type="password" name="re-password" class="form-control" id="password1" value="{{ old('re-password') }}">
                                        @error('re-password')
                                            <div class="text-danger text-left" style="font-size:14px;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="address" class="form-label">Địa chỉ</label>
                                        <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}">
                                        @error('address')
                                            <div class="text-danger text-left" style="font-size:14px;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="phone" class="form-label">Số điện thoại<span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="text-danger text-left" style="font-size:14px;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label for="gender" class="form-label">Giới tính<span class="text-danger">*</span></label>
                                    </div>
                                    <select class="form-select" name="gender" id="gender">
                                        @foreach (\App\Models\User::$genderArr as $item)
                                            <option value="{{$item}}" {{ (old("gender") == $item) ? 'selected' : '' }}>
                                                @if($item==App\Models\User::GENDER_MALE) Nam
                                                @elseif($item==App\Models\User::GENDER_FEMALE) Nữ
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning text-white font-weght-bold" style="background-color:#ff723a!important;">Đăng ký</button>
                            </form>
                       </div>
                     </div>
                     <div class="col-lg-6">
                         <div class="contact-img contact-img-02 mb-30">
                             <img class="img-fluid" src="https://scontent.fhan14-1.fna.fbcdn.net/v/t39.30808-6/217734297_2990779634581507_2984849669823464276_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=730e14&_nc_ohc=JtBOTxSk7t8AX_E3PP9&_nc_ht=scontent.fhan14-1.fna&oh=00_AT9jxF9IS6sokx0AD21AhpXin4y55j4Ayj3seshtDrlqVw&oe=62AEE906" alt="">
                         </div>
                     </div>
                 </div>
             </div>
         </section>
         <!--contact-form-area end-->
    </main>
@endsection
