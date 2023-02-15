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
                <!--begin::Portlet-->
                    <div class="kt-portlet">
{{--                        <div class="kt-portlet__head kt-portlet__head--lg">--}}
{{--                            @include('gwc.templateIncludes.portletHead')--}}
{{--                            @include('gwc.templateIncludes.portletHeadToolbar')--}}
{{--                        </div>--}}
                        @if(auth()->guard('admin')->user()->can($data['viewPermission']))
                        <link href="{{asset('/admin_assets/assets/css/pages/invoices/invoice-1.css')}}" rel="stylesheet" type="text/css">
                        <div class="kt-portlet__body kt-portlet__body--fit">
                            <div class="kt-invoice-1">
                                <div class="kt-invoice__head"
                                     style="background-image: url({{url('admin_assets/assets/media/bg/bg-6.jpg')}});">
                                    <div class="kt-invoice__container" style="width:100%;">
                                        <div class="kt-invoice__brand">
                                            <h1 class="kt-invoice__title">{{strtoupper(__('adminMessage.details'))}}</h1>
                                            <div class="kt-invoice__logo">
                                                <div class="kt-invoice__desc">
                                                    <div>
                                                        <b class="text-white">{{$resource->created_at}}</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-invoice__items">
                                            <div class="kt-invoice__item">
                                                <span class="kt-invoice__subtitle">{{strtoupper(__('adminMessage.user_details'))}}</span>
                                                <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.name'))}}: </b> {{$resource['user']->first_name . ' ' . $resource['user']->last_name}}</span>
                                                <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.user_phone_number'))}}: </b> {{$resource['user']->mobile }}</span>
                                            </div>
                                            <div class="kt-invoice__item">
                                                <span class="kt-invoice__text">
                                                    <img width="90" src="{{'/uploads/users/thumb/'.$resource['user']->image}}" alt="">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="kt-invoice__body">
                                    <div class="kt-invoice__container" style="width:100%;">
                                        <div class="table-responsive">
                                            <table class="table table-striped-  table-hover table-checkable">
                                                <thead>
                                                <tr>
                                                    <th>{{__('adminMessage.description')}}</th>
                                                    <th style="text-align:center;">{{__('adminMessage.budget')}}</th>
                                                    <th style="text-align:center;">{{__('adminMessage.place')}}</th>
                                                    <th style="text-align:center;">{{__('adminMessage.time')}}</th>
                                                    <th style="text-align:center;">{{__('adminMessage.payment_type')}}</th>
                                                    <th style="text-align:center;">{{__('adminMessage.attachment')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr id="cart-1">
                                                    <td>
                                                      {!! $resource->description !!}
                                                    </td>
                                                    <td>
                                                        {{$resource->budget}}
                                                    </td>
                                                    <td>
                                                        {{$resource->place}}
                                                    </td>
                                                    <!--Delete modal -->
                                                    <td>
                                                        {{$resource->time}}
                                                    </td>
                                                    <td>
                                                        {{$resource->payment_type}}
                                                    </td>
                                                    <td>
                                                        @foreach(explode(',', $resource->attachment) as $image)
                                                             @if($image)
                            <div>
                                <form action="{{route('download.quotation')}}">
                                    @csrf
                                    <input type="hidden" name="image" value="{{$image}}">
                            <button type="submit" >download</a>
                            </form>
                            </div>
                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn" onclick="window.print()">
                                                <i class="kt-nav__link-icon flaticon2-print"></i>
                                                <span class="kt-nav__link-text">{{__('adminMessage.print')}}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            @include('gwc.templateIncludes.permissionWarning')
                        @endif
                    </div>
                </div>
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

