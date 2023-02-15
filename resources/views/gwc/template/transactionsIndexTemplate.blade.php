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
            @include('gwc.templateIncludes.transactionsIndexSubHeader')

            <!-- begin:: Content -->
                <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
                @include('gwc.templateIncludes.successErrorMessage')
                <!--begin::Portlet-->
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            @include('gwc.templateIncludes.portletHead')
                        </div>
                        <div class="kt-portlet__body">
                            @if(auth()->guard('admin')->user()->can($data['listPermission']))
                                @yield('indexContent')
                            @else
                                @include('gwc.templateIncludes.permissionWarning')
                            @endif
                        </div>
                    </div>
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
@include('gwc.js.search')

<script>
    $(function() {
        $('input[name="kt_daterangepicker_range"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });

    function copyToClipboard(elementId) {
        // Create a "hidden" input
        var aux = document.createElement("input");
        // Assign it the value of the specified element
        aux.setAttribute("value", document.getElementById(elementId).innerHTML);
        // Append it to the body
        document.body.appendChild(aux);
        // Highlight its content
        aux.select();
        // Copy the highlighted text
        document.execCommand("copy");
        // Remove it from the body
        document.body.removeChild(aux);
        //toast
        toastr.success("Order Text Message Has Been Coppied");
    }
</script>

</body>
</html>