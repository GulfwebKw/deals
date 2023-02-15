@extends('gwc.template.orders3IndexTemplate')

@section('indexContent')

    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.user_name')}}</th>
            <th>{{__('adminMessage.price')}}</th>
            <th>Earn</th>
            <th>commission</th>
            <th>Refund</th>
            <th>Num. services</th>
            <th>Order Status</th>
            <th>Order Track</th>
            <th>{{__('adminMessage.order_date')}}</th>
            <th width="10">{{__('adminMessage.actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @php
                $p=1;
                $orderStatus='';
            @endphp
            @foreach($resources as $resource)
                @php
                    if(!empty($resource->payment_status) && $resource->payment_status=="waiting"){
                        $orderStatus ='<span class="kt-badge kt-badge--inline kt-badge--warning">Waiting</span>';
                    }
                    elseif(!empty($resource->payment_status) && $resource->payment_status=="paid"){
                        $orderStatus ='<span class="kt-badge kt-badge--inline kt-badge--success">Paid</span>';
                    }
                      elseif(!empty($resource->payment_status) && $resource->payment_status=="cancel"){
                        $orderStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger">Cancel</span>';
                    }
                @endphp
                <tr class="search-body">
                    <td>
                        {{$p}}
                    </td>
                    <td>
                        <a href="/gwc/users?id={{$resource['user']->id}}">{!! $resource['user']->first_name . ' ' . $resource['user']->last_name!!}</a>
                    </td>
                    <td>
                        {!! $resource->amount !!}
                    </td>
                    <td>
                        {!! $resource->services->sum('earn') !!}
                    </td>
                    <td>
                        {!! $resource->services->sum('commission') !!}
                    </td>
                    <td>
                        {!! $resource->refund !!}
                    </td>
                    <td>
                        {!! $resource->services->count() !!}
                    </td>
                    <td>
                        {!! $orderStatus !!}
                    </td>
                    <td>
                        {!! $resource->order_track !!}
                    </td>
                    <td>
                        {!! $resource->created_at !!}
                    </td>
                    <td class="kt-datatable__cell">
                        <span style="overflow: visible; position: relative; width: 80px;">
                            <div class="dropdown">
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        @if(auth()->guard('admin')->user()->can($data['viewPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{url('gwc/services-orders/' . $resource->id . '/details')}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon-eye"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.view')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </span>
                    </td>
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