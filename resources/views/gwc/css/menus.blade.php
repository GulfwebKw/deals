<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
		<!--end::Fonts -->
		<!--begin::Page Vendors Styles(used by this page) -->
		<link href="{!! asset('admin_assets/assets/plugins/custom/datatables/datatables.bundle.css')!!}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles -->
		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="{!! asset('admin_assets/assets/plugins/global/plugins.bundle.css') !!}" rel="stylesheet" type="text/css" />
		<link href="{!! asset('admin_assets/assets/css/style.bundle.css') !!}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles -->
		<!--begin::Layout Skins(used by all pages) -->
		<link href="{!! asset('admin_assets/assets/css/skins/header/base/light.css') !!}" rel="stylesheet" type="text/css" />
		<link href="{!! asset('admin_assets/assets/css/skins/header/menu/light.css') !!}" rel="stylesheet" type="text/css" />
		<link href="{!! asset('admin_assets/assets/css/skins/brand/dark.css') !!}" rel="stylesheet" type="text/css" />
		<link href="{!! asset('admin_assets/assets/css/skins/aside/dark.css') !!}" rel="stylesheet" type="text/css" />
        
		<!--end::Layout Skins -->
		@php
        $settingInfo = App\Http\Controllers\WebController::settings();
        @endphp
        @if($settingInfo->favicon)
        <link rel="shortcut icon" href="{{asset('uploads/logo/'.$settingInfo->favicon)}}">
        @endif