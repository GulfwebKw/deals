@extends('gwc.template.viewTemplate')

@section('viewContent')
    <link href="{{asset('/admin_assets/assets/css/pages/invoices/invoice-1.css')}}" rel="stylesheet" type="text/css">
    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-invoice-1">
            <div class="kt-invoice__head"
                 style="background-image: url({{url('admin_assets/assets/media/bg/bg-2.jpg')}});">
                <div class="kt-invoice__container" style="width:100%;">
                    <div class="kt-invoice__items">
                        <div class="kt-invoice__item">
                            <span class="kt-invoice__subtitle">{{strtoupper(__('adminMessage.user_details'))}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.name'))}}: </b> <a href="/gwc/users/{{$user->id ?? 0}}/edit">{{ ( $user->first_name ?? '[UNKNOW]' ) . ' ' . ( $user->last_name ?? "--" ) }}</a></span>
                            <span class="kt-invoice__text"><b>{{strtoupper(__('adminMessage.user_phone_number'))}}: </b> {{$user->mobile ?? "--"}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper('Email')}}: </b> {{$user->email ?? "--"}}</span>
                        </div>
                        <div class="kt-invoice__item">
                            <span class="kt-invoice__subtitle">{{strtoupper('Freelancer Details')}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper('Freelancer name' )}}: </b> <a href="/gwc/freelancers?id={{$freelancer->id ?? 0}}">{{$freelancer->name ?? "--" }}</a></span>
                            <span class="kt-invoice__text"><b>{{strtoupper('Freelancer username' )}}: </b> <a href="/gwc/freelancers?id={{$freelancer->id ?? 0}}">{{$freelancer->username ?? "--" }}</a></span>
                            <span class="kt-invoice__text"><b>{{strtoupper('phone')}}: </b> {{$freelancer->phone ?? "--"}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper('email')}}: </b> {{$freelancer->email ?? "--"}}</span>
                            <span class="kt-invoice__text"><b>{{strtoupper('gender')}}: </b> {{$freelancer->gender ?? "--"}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kt-invoice__body">
                <div class="kt-invoice__container" style="width:100%;">
                    <div class="table-responsive">
                        <table class="table table-striped-  table-checkable">
                            <tbody>
                                <tr>
                                    <th class="text-center" colspan="2" width="50%">
                                        {{ $location_type }} Location
                                    </th>
                                    <th class="text-center" colspan="2" width="50%">
                                        {{ $type }} Details
                                    </th>
                                </tr>
                                <tr>
                                    <th  width="15%">
                                        Name of address
                                    </th>
                                    <th class="font-weight-light" width="35%">
                                        {{ $location->full_name  ?? "--" }}
                                    </th>
                                    <th width="15%">
                                        Name
                                    </th>
                                    <th class="font-weight-light" width="35%">
                                        {{ $resource->name  ?? "--" }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Area
                                    </th>
                                    <th class="font-weight-light">
                                        {{ ( $type == 'workshop' ? ( $location->area ? ( $location->area->city ? $location->area->city->title_en : "--" ) : "--" ) : $location->area )   ?? "--" }}
                                    </th>
                                    <th>
                                        Unit Price
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $resource->price  ?? "--" }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        City
                                    </th>
                                    <th class="font-weight-light">
                                        {{ ( $type == 'workshop' ? ( $location->area ? $location->area->title_en : "--" ) : $location->city )   ?? "--" }}
                                    </th>
                                    <th>
                                        Date/Time
                                    </th>
                                    <th class="font-weight-light">
                                        {{ ( $type == 'workshop' ? $resource->date  : $order->date ) ?? "--" }} {{ ( $type == 'workshop' ? $resource->from_time .' => '. $resource->to_time : $order->time )  ?? "--" }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Block
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $location->block  ?? "--" }}
                                    </th>
                                    <th>
                                        status
                                    </th>
                                    <th class="font-weight-light">
                                        {{ str_replace('_' , ' ', ( $type == 'workshop' ? $order->payment_status  : $order->status ) ?? "--" )   }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Avenue
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $location->avenue  ?? "--" }}
                                    </th>
                                    <th>
                                        Number of people
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $order->people ?? $order->people_count ?? "--" }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Street
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $location->street  ?? "--" }}
                                    </th>
                                    <th>
                                        Rate
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $order->rate  ?? "--" }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        House/Apartment
                                    </th>
                                    <th class="font-weight-light">
                                        {{ ( $type == 'workshop' ? $location->building_name  : $location->house_apartment )  ?? "--" }}
                                    </th>
                                    <th class="text-center" colspan="2">
                                    
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Floor
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $location->floor  ?? "--" }}
                                    </th>
                                    <th class="text-center" colspan="2">
                                    
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="4">
                                        Payment Information
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Order Track
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $payment->order_track  ?? "--" }}
                                    </th>
                                    <th>
                                        Payment id
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $payment->payment_id  ?? "--" }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Gateway Result
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $payment->result  ?? "--" }}
                                    </th>
                                    <th>
                                        Gateway Message
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $payment->error  ?? "--" }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Payment Status
                                    <th class="font-weight-light">
                                        {{ $payment->payment_status  ?? "--" }}
                                    </th>
                                    <th>
                                        Payment Amount
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $payment->amount  ?? "--" }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Freelancer Earn
                                    <th class="font-weight-light">
                                        {{ $order->earn  ?? "--" }}
                                    </th>
                                    <th>
                                        Commission
                                    </th>
                                    <th class="font-weight-light">
                                        {{ $order->commission  ?? "--" }}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>





@endsection
