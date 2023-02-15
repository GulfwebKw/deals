@extends('gwc.template.transactionsIndexTemplate')

@section('indexContent')

    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>Track ID</th>
            <th>Order ID</th>
            <th>Payment ID</th>
            <th>Amount</th>
            <th>Payment Status</th>
            <th>Status</th>
            <th>Date Created</th>
{{--            <th width="10">{{__('adminMessage.actions')}}</th>--}}
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @php
                $p=1;
                $paymentStatus='';
            @endphp
            @foreach($resources as $resource)
                @php
                    if(!empty($resource->payment_status) && $resource->payment_status=="paid"){
                        $paymentStatus ='<span class="kt-badge kt-badge--inline kt-badge--success">Paid</span>';
                    }
                    elseif(!empty($resource->payment_status) && $resource->payment_status=="notpaid"){
                        $paymentStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger">Not Paid</span>';
                    }
                @endphp
                <tr class="search-body">
                    <td>
                        {{$p}}
                    </td>
                    <td>
                        {!! $resource->trackid !!}
                    </td>
                    <td>
                        {!! $resource->order_id !!}
                    </td>
                    <td>
                        {!! $resource->paymentid !!}
                    </td>
                    <td>
                        {!! $resource->amount !!}
                    </td>
                    <td>
                        {!! $resource->presult !!}
                    </td>
                    <td>
                        {!! $paymentStatus !!}
                    </td>
                    <td>
                        {!! $resource->created_at !!}
                    </td>
{{--                    <td class="kt-datatable__cell">--}}
{{--                        <span style="overflow: visible; position: relative; width: 80px;">--}}
{{--                            <div class="dropdown">--}}
{{--                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">--}}
{{--                                    <i class="flaticon-more-1"></i>--}}
{{--                                </a>--}}
{{--                                <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                    <ul class="kt-nav">--}}
{{--                                        @if(auth()->guard('admin')->user()->can($data['viewPermission']))--}}
{{--                                            <li class="kt-nav__item">--}}
{{--                                                <a href="{{url($data['url'] . $resource->id . '/view')}}" class="kt-nav__link">--}}
{{--                                                    <i class="kt-nav__link-icon flaticon-eye"></i>--}}
{{--                                                    <span class="kt-nav__link-text">{{__('adminMessage.view')}}</span>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                        @if(auth()->guard('admin')->user()->can($data['printPermission']))--}}
{{--                                            <li class="kt-nav__item">--}}
{{--                                                <a href="{{url($data['url'] . $resource->id . '/print')}}" class="kt-nav__link">--}}
{{--                                                    <i class="kt-nav__link-icon flaticon2-print"></i>--}}
{{--                                                    <span class="kt-nav__link-text">{{__('adminMessage.print')}}</span>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </span>--}}
{{--                    </td>--}}
                </tr>
                @php $p++; @endphp
            @endforeach
            <tr>
                <td colspan="9" class="text-center">{{ $resources->links() }}</td>
            </tr>
        @else
            <tr>
                <td colspan="9"
                    class="text-center">{{__('adminMessage.recordnotfound')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection