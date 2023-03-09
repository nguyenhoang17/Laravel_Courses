@extends('admin.auth.auth_layouts')
@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <!--begin::Logo-->
        <a href="{{route('admin.dashboard')}}" class="mb-12">
            <img alt="Logo" src="https://zent.edu.vn/zent_logo_dark.png" class="h-75px" />
        </a>
        <!--end::Logo-->
        <!--begin::Wrapper-->
        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            <form action="{{ route('admin.login.authenticate') }}" method="POST">
                @csrf
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">Đăng nhập</h1>
                    <!--end::Link-->
                </div>
                <!--begin::Heading-->
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" value="{{ old('email') }}" />
                    <!--end::Input-->
                    @error('email')
                        <div class="fv-plugins-message-container invalid-feedback">
                            <div>{{ $message }}</div>
                        </div>
                    @enderror

                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack mb-2">
                        <!--begin::Label-->
                        <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                        <!--end::Link-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Input-->
                    <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" value="{{ old('password') }}" />
                    <!--end::Input-->
                    @error('password')
                        <div class="fv-plugins-message-container invalid-feedback">
                            <div>{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="text-center">
                    <!--begin::Submit button-->
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">Đăng nhập</span>
                        <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
    </div>
@endsection

@section('js')
    <link rel="stylesheet" href="/admin/dist/assets/js/toastr/toastr.min.js">
    <script type="text/javascript" src="/user/assets/js/toastr.js"></script>
    <link media="screen" rel="stylesheet" type="text/css" href="/user/assets/css/toastr.css"/>
    @error('login')
        <script>
            toastr.error("{{$message}}");
        </script>
    @enderror
    @if(Session::has('success'))
        <script>
            toastr.success("{!! session()->get('success') !!}");
        </script>
    @elseif(Session::has('error'))
        <script>
            toastr.error("{!! session()->get('error') !!}");
        </script>
    @endif
@endsection
