@extends('gwc.template.viewTemplate')

@section('viewContent')
    <link href="{{asset('/admin_assets/assets/css/pages/invoices/invoice-1.css')}}" rel="stylesheet" type="text/css">
    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-invoice-1">
            <div class="kt-invoice__head"
                 style="background-image: url({{url('admin_assets/assets/media/bg/bg-6.jpg')}});">
                <div class="kt-invoice__container" style="width:100%;">
                    <div class="kt-invoice__items">
                        <div class="kt-invoice__item">
                            <span class="kt-invoice__subtitle">{{strtoupper(__('adminMessage.user_details'))}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.name'))}}: </b> {{$resource['user']->first_name . ' ' . $resource['user']->last_name}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.user_phone_number'))}}: </b> {{$resource['user']->mobile }}</span>
                        </div>
                        <div class="kt-invoice__item">
                            <span class="kt-invoice__subtitle">{{strtoupper('Details')}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper('Booking date' )}}: </b> {{$resource->created_at}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.total'))}}: </b> {{$resource->amount}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.status'))}}: </b> {{$resource->status==1?'paid':'faild'}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.order_track'))}}: </b> {{$resource->order_track}}</span>
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
                                <th>{{__('adminMessage.service_name')}}</th>
                                <th style="text-align:center;">Freelancer</th>
                                <th style="text-align:center;">Number of people</th>
                                <th style="text-align:center;">{{__('adminMessage.price')}}</th>
                                <th style="text-align:center;">Freelancer earn</th>
                                <th style="text-align:center;">commission</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($resource['services'] as $service)
                            <tr>
                                <td>
                                    <a href="/gwc/services?id={{$service['service']->id}}">{{$service['service']->name}}</a>
                                </td>
                                <td>
                                    <a href="/gwc/freelancers?id={{$service['freelancer']->id}}" >{{$service['freelancer']->name}}</a>
                                </td>
                                <td>
                                    {{$service->people}}
                                </td>
                                <td>
                                    {{$service->price}}
                                </td>
                                <td>
                                    {{$service->earn}}
                                </td>
                                <td>
                                    {{$service->commission}}
                                </td>
                                <td>
                                    {{ str_replace('_' , ' ',  $service->status )  }}
                                </td>
                                <td>
                                    <a href="/gwc/book-details/service/{{$service->id}}" >Details</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>





@endsection
