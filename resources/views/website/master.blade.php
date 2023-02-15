<!DOCTYPE html>
<html lang="en" class="{{ app()->getLocale() == 'ar' ? "rtl" : "ltr" }}">
<head>
    @include('website.templateSections.head')
</head>
<body>
@include('website.templateSections.topNav')

@yield('content')

@include('website.templateSections.footer')
@include('website.templateSections.script')
</body>
</html>