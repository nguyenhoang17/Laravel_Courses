@extends('user.layouts.master')
@section ('title')
    Cài đặt người dùng
@endsection
@section ('content')
    <main>
        <!--page-title-area start-->
         <section class="page-title-area d-flex align-items-end" style="background-image: url('https://images.unsplash.com/photo-1518655048521-f130df041f66?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8d29yayUyMGRlc2t8ZW58MHx8MHx8&w=1000&q=80');">
             <div class="container">
                 <div class="row align-items-end">
                     <div class="col-lg-12">
                         <div class="page-title-wrapper mb-50">
                            <h1 class="page-title mb-25">Cài đặt người dùng</h1>
                            <div class="breadcrumb-list">
                               <ul class="breadcrumb">
                                   <li><a href="index.html">Trang chủ -</a></li>
                                   <li><a href="#">&nbsp;Cài đặt người dùng</a></li>
                               </ul>
                            </div>
                       </div>
                     </div>
                 </div>
             </div>
         </section>
         <!--page-title-area end-->
         <!--contact-form-area start-->
         <section class="contact-form-area pt-100 pb-120 pb-md-70 pb-xs-70">
             <div class="container">
                 <div class="row justify-content-center">
                    <div class="col-lg-6">
                       <div class="contact-form-wrapper mb-30">
                            <h2 class="mb-45">Thông tin cá nhân</h2>
                            <form action="{{ route('settings.update',Auth::guard('web')->user()->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên đầy đủ<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" value="@if(!empty(old("name"))){{old("name")}}@else{{ $user->name }}@endif">
                                    @error('name')
                                        <div class="text-danger text-left" style="font-size:14px;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                               <div class="mb-3">
                                   <label for="name" class="form-label">Email</label>
                                   <input type="text" readonly class="form-control" value="{{ $user->email }}">
                               </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="address" class="form-label">Địa chỉ</label>
                                        <input type="text" name="address" class="form-control" id="address" value="@if(!empty(old("address"))){{old("address")}}@else{{ $user->address }}@endif">
                                        @error('address')
                                            <div class="text-danger text-left" style="font-size:14px;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="phone" class="form-label">Số điện thoại<span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" id="phone" value="@if(!empty(old("phone"))){{old("phone")}}@else{{ $user->phone }}@endif">
                                        @error('phone')
                                            <div class="text-danger text-left" style="font-size:14px;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Giới tính<span class="text-danger">*</span></label>
                                    <select class="form-select" name="gender" id="gender">
                                        @foreach (\App\Models\User::$genderArr as $item)
                                            <option value="{{$item}}" {{ ($user->gender == $item) ? 'selected' : '' }}>
                                                @if($item==App\Models\User::GENDER_MALE) Nam
                                                @elseif($item==App\Models\User::GENDER_FEMALE) Nữ
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning text-white font-weght-bold" style="background-color: #ff723a !important;">Lưu</button>
                            </form>
                       </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-form-wrapper mb-30">
                            <h2 class="mb-45">Đổi mật khẩu</h2>
                            <form id="form-change" action="{{ route('settings.change',Auth::guard('web')->user()->id)}}" method="POST">
                                @csrf 
                                <div class="mb-3">
                                     <label for="current_password" class="form-label">Mật khẩu cũ<span class="text-danger">*</span></label>
                                     <input type="password" name="current_password" id="current_password" class="form-control" value="{{ old('current_password') }}">
                                     @error('current_password')
                                        <div class="text-danger" style="font-size:14px;">
                                            {{ $message }}
                                        </div>
                                     @enderror
                                 </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Mật khẩu mới<span class="text-danger">*</span></label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" value="{{ old('new_password') }}">
                                    @error('new_password')
                                        <div class="text-danger" style="font-size:14px;">
                                            {{ $message }}
                                        </div>
                                     @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="re_new_password" class="form-label">Xác nhận mật khẩu mới<span class="text-danger">*</span></label>
                                    <input type="password" name="re_new_password" id="re_new_password" class="form-control" value="{{ old('re_new_password') }}">
                                    @error('re_new_password')
                                         <div class="text-danger" style="font-size:14px;">
                                            {{ $message }}
                                         </div>
                                    @enderror
                                </div>
                                <button type="button" id="change_pass" class="btn btn-warning text-white font-weght-bold" style="background-color: #ff723a !important;">Xác nhận</button>
                            </form>
                        </div>
                    </div>
                 </div>
             </div>
         </section>
         <!--contact-form-area end-->
    </main>
@endsection
@section('script')
    <script src="/user/assets/js/sweetalert2.js"></script>
    <script src="/user/assets/js/setting.js"></script>
@endsection

