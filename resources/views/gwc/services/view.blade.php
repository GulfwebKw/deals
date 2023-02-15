@extends('gwc.template.viewTemplate')

@section('viewContent')
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
                            <span class="kt-invoice__subtitle">{{strtoupper(__('adminMessage.freelancer_details'))}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.name'))}}: </b> {{$resource['service']['freelancer']->name}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.freelancer_phone_number'))}}: </b> {{$resource['service']['freelancer']->phone}}</span>
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
                                <th>{{__('adminMessage.image')}}</th>
                                <th style="text-align:center;">{{__('adminMessage.service_name')}}</th>
                                <th style="text-align:center;">{{__('adminMessage.price')}}</th>
                                <th style="text-align:center;">{{__('adminMessage.booked_date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="cart-1">
                                <td>
                                    <img src="{{'/uploads/freelancer_services/thumb/'.$resource['service']->image}}"
                                         width="50">
                                </td>
                                <td>
                                    {{$resource['service']->name}}
                                </td>
                                <td>
                                    {{$resource['service']->price}}
                                </td>
                                <!--Delete modal -->
                                <td>
                                    {{$resource->created_at}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="kt-invoice__footer">
                <div class="kt-invoice__container" style="width:100%;">
                    <div class="kt-invoice__total align-items-start">
                        <span class="kt-invoice__title">{{strtoupper(__('adminMessage.total'))}}</span>
                        <span class="kt-invoice__price">{{$resource['service']->price}}</span>

                        {{--                        @if(!empty($orderDetails->seller_discount))--}}
                        <span class="kt-invoice__notice">{{strtoupper(__('adminMessage.discount'))}}</span>
                        {{--                            <span class="kt-invoice__price">-{{number_format($orderDetails->seller_discount,3)}} {{$settingInfo->base_currency}} </span>--}}
                        <span class="kt-invoice__price">0</span>
                        {{--                            @php--}}
                        {{--                                $totalprice=$totalprice-$orderDetails->seller_discount;--}}
                        {{--                            @endphp--}}
                        {{--                        @endif--}}


                        {{--                        @if(!empty($orderDetails->coupon_code) && empty($orderDetails->coupon_free))--}}
                        {{--                            <span class="kt-invoice__notice">{{strtoupper(__('adminMessage.coupon_discount'))}}</span>--}}
                        {{--                            <span class="kt-invoice__price">-{{number_format($orderDetails->coupon_amount,3)}} {{$settingInfo->base_currency}} </span>--}}
                        {{--                            @php--}}
                        {{--                                $totalprice=$totalprice-$orderDetails->coupon_amount;--}}
                        {{--                            @endphp--}}
                        {{--                        @endif--}}

                        {{--                        @if(!empty($orderDetails->coupon_code) && !empty($orderDetails->coupon_free))--}}
                        {{--                            <span class="kt-invoice__notice">{{strtoupper(__('adminMessage.coupon_discount'))}}</span>--}}
                        {{--                            <span class="kt-invoice__price">{{__('adminMessage.free_delivery')}}</span>--}}
                        {{--                        @endif--}}

                        {{--                        @if(empty($orderDetails->delivery_charges))--}}
                        {{--                            <span class="kt-invoice__notice">{{strtoupper(__('adminMessage.delivery_charge'))}}</span>--}}
                        {{--                            <span class="kt-invoice__price">{{__('adminMessage.free_delivery')}}</span>--}}
                        {{--                        @endif--}}

                        {{--                        @if(!empty($orderDetails['delivery_charges']) && empty($orderDetails['coupon_free']))--}}
                        {{--                            <span class="kt-invoice__notice">{{strtoupper(__('adminMessage.delivery_charge'))}}</span>--}}
                        {{--                            <span class="kt-invoice__price">{{number_format($orderDetails['delivery_charges'],3)}} {{$settingInfo->base_currency}}</span>--}}
                        {{--                            @php--}}
                        {{--                                $totalprice=$totalprice+$orderDetails['delivery_charges'];--}}
                        {{--                            @endphp--}}
                        {{--                        @endif--}}
                        <span class="kt-invoice__title">{{strtoupper(__('adminMessage.grandtotal'))}}</span>
                        {{--                        <span class="kt-invoice__price">{{number_format($totalprice,3)}} {{$settingInfo->base_currency}} </span>--}}
                        <span class="kt-invoice__price">{{$resource['service']->price}}</span>

                    </div>
                </div>
            </div>

            <div class="kt-invoice__actions">
                <div class="kt-invoice__container" style="width:100%;">
                    <div class="row" style="width:100%;">
                        <div class="col-lg-6">
                            <a href="{{url('order-print/1')}}"
                               style="color:#FFFFFF;" target="_blank"
                               class="btn btn-warning btn-bold"
                               title="{{__('adminMessage.printinvoice')}}"><i
                                        class="flaticon2-print"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection