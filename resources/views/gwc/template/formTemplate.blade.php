<!DOCTYPE html>
<html lang="en">
<head>
    @include('gwc.templateIncludes.head')
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed">
    @include('gwc.templateIncludes.headerMobile')
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            @include('gwc.templateIncludes.leftMenu')
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                @include('gwc.templateIncludes.header')
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                    @include('gwc.templateIncludes.formSubHeader')

                    <!-- begin:: Content -->
                    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
                        @include('gwc.templateIncludes.successErrorMessage')
                        @if(auth()->guard('admin')->user()->can($data['editPermission']))
                            @yield('formContent')
                        @else
                            @include('gwc.templateIncludes.permissionWarning')
                        @endif
                    </div>
                    <!-- end:: Content -->
                </div>
                @include('gwc.templateIncludes.footer')
            </div>
        </div>
    </div>

    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    @include('gwc.js.user')
    @include('gwc.js.tinymce')
</body>
</html>