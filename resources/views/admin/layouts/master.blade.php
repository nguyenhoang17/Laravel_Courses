<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>Zent Online Courses</title>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
        <link href="/admin/dist/assets/sass/components/_modal.scss" rel="stylesheet" />
        <link href="/admin/dist/assets/sass/components/_variables.scss" rel="stylesheet" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="/admin/dist/assets/media/logos/icon-zent.png"/>
		<!--begin::Fonts-->
		@yield('css')
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="/admin/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="/admin/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/admin/dist/assets/css/tooltip.css" rel="stylesheet" type="text/css" />
		<link href="/admin/dist/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
		<!--end::Global Stylesheets Bundle-->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<style>

		</style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
			  @include('admin.includes.aside')
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
			  @include('admin.includes.header')
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
                                @yield('content')
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
			  @include('admin.includes.footer')
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--begin::Drawers-->
		<!--begin::Activities drawer-->
		<!--end::Help drawer-->
		<!--end::Engage drawers-->
		<!--begin::Engage toolbar-->

		<!--end::Engage toolbar-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		<!--begin::Modals-->
		<!--begin::Modal - Upgrade plan-->
		<!--end::Modal - Users Search-->
		<!--end::Modals-->
		<!--begin::Javascript-->
		<script>var hostUrl = "/admin/dist/assets/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="/admin/dist/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/admin/dist/assets/js/scripts.bundle.js"></script>
        <script src="/admin/dist/assets/js/font-awesome/all.min.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="/admin/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<!-- datatable -->
		<script src="/admin/dist/assets/plugins/custom/datatables/datatables1.bundle.js"></script>
		<!--end::Page Vendors Javascript-->
		<script src="/admin/dist/assets/js/custom/apps/ecommerce/catalog/categories.js"></script>
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="/admin/dist/assets/js/widgets.bundle.js"></script>
		<script src="/admin/dist/assets/js/custom/widgets.js"></script>
		<script src="/admin/dist/assets/js/custom/apps/chat/chat.js"></script>
		<script src="/admin/dist/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="/admin/dist/assets/js/custom/utilities/modals/create-app.js"></script>
		<script src="/admin/dist/assets/js/custom/utilities/modals/users-search.js"></script>
		<script src="/admin/dist/assets/js/custom/apps/user-management/users/list/table.js"></script>
		<script src="/admin/dist/assets/js/custom/apps/user-management/users/list/export-users.js"></script>
		<script src="/admin/dist/assets/js/custom/apps/user-management/users/list/add.js"></script>
        <script src="/admin/dist/assets/js/jquery.dataTables.min.js"></script>
        @if(Session::has('success'))
            <script>
                toastr.success("{!! session()->get('success') !!}");
            </script>
        @elseif(Session::has('error'))
            <script>
                toastr.error("{!! session()->get('error') !!}");
            </script>
        @endif
        <!--end::Page Custom Javascript-->
		<!--end::Page Custom Javascript-->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
		<!--end::Javascript-->
		@yield('js')
	</body>
	<!--end::Body-->
</html>
