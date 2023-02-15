@extends('gwc.template.orders3IndexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
             <th>Freelancer Name</th>
            <th>{{__('adminMessage.order_track')}}</th>
            <th>{{__('adminMessage.payment_id')}}</th>
            <th>{{__('adminMessage.package_name')}}</th>
            <th>{{__('adminMessage.amount')}}</th>
            <th>{{__('adminMessage.payment_status')}}</th>
            <th>{{__('adminMessage.result')}}</th>
            <th>{{__('adminMessage.error')}}</th>
            <th>{{__('adminMessage.created_at')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @php
                $p=1;
                $orderStatus='';
            @endphp
            @foreach($resources as $resource)
                <tr class="search-body">
                    <td>
                        {{$p}}
                    </td>
                       <td>
                        <a href="/gwc/freelancers?id={{$resource->freelancer_id}}">{!!$resource['freelancer']->name!!}</a>
                    </td>
                    <td>
                        {!! $resource->order_track !!}
                    </td>
                    <td class="kt-datatable__cell">
                        {!! $resource->payment_id !!}
                    </td>
                    <td>
                        {!! $resource['package']->name !!}
                    </td>
                    <td class="kt-datatable__cell">
                        <b>{!! $resource->amount !!}</b>
                    </td>
                    <td class="kt-datatable__cell">
                        @if($resource->payment_status=='paid')
                            <span class="text-success">{!! $resource->payment_status !!}</span>
                        @else
                            <span class="text-danger">{!! $resource->payment_status !!}</span>
                        @endif
                    </td>
                    <td class="kt-datatable__cell">
                        @if($resource->result=='CAPTURED')
                            <span class="text-success">{!! $resource->result !!}</span>
                        @else
                            <span class="text-danger">{!! $resource->result !!}</span>
                        @endif
                    </td>
                    <td class="kt-datatable__cell">
                        @if($resource->error=='Transaction Success')
                            <span class="text-success">{!! $resource->error !!}</span>
                        @else
                            <span class="text-danger">{!! $resource->error !!}</span>
                        @endif
                    </td>
                    <td class="kt-datatable__cell">
                        {!! $resource->created_at !!}
                    </td>
                </tr>
                @php $p++; @endphp
            @endforeach
            <tr>
                {{--                <td colspan="9" class="text-center">{{ $resources->links() }}</td>--}}
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