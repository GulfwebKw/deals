@extends('gwc.template.ordersIndexTemplate')

@section('indexContent')

    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>Order Track</th>
            <th>{{__('adminMessage.package_name')}}</th>
            <th>{{__('adminMessage.total')}}</th>
            <th>{{__('adminMessage.order_status')}}</th>
            <th>{{__('adminMessage.pay_status')}}</th>
            <th>{{__('adminMessage.date')}}</th>
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
                    if(!empty($resource->payment_status) && $resource->payment_status=="paid"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--success">Paid</span>';
                    }
                    elseif(!empty($resource->payment_status) && $resource->payment_status=="notpaid"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger">Not Paid</span>';
                    }

                    if(!empty($resource->order_status) && $resource->order_status=="pending"){
                        $orderStatus ='<span class="kt-badge kt-badge--inline kt-badge--warning">'.$resource->order_status.'</span>';
                    }
                    elseif(!empty($resource->order_status) && $resource->order_status=="success"){
                        $orderStatus ='<span class="kt-badge kt-badge--inline kt-badge--success">'.$resource->order_status.'</span>';
                    }
                      elseif(!empty($resource->order_status) && $resource->order_status=="failed"){
                        $orderStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger">'.$resource->order_status.'</span>';
                    }
                @endphp
                <tr class="search-body">
                    <td>
                        {{$p}}
                    </td>
                    <td>
                        {!! $resource->order_track !!}
                    </td>
                    <td>
                        {!! $resource->package->name !!}
                    </td>
                    <td>
                        {!! $resource->amount !!}
                    </td>
                    <td>
                        {!! $orderStatus !!}
                    </td>
                    <td>
                        {!! $payStatus !!}
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
                                                <a href="{{url($data['url'] . $resource->id . '/view')}}" class="kt-nav__link">
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