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
                                        <div>
                                            <a href="{{route('download.quotation', $image)}}">{!! $image !!}</a>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection