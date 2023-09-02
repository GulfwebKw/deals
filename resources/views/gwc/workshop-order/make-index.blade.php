@extends('gwc.template.orders3IndexTemplate')

@section('indexContent')

    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.workshop_name')}}</th>
            <th>Number Of people</th>
            <th>Price</th>
            <th>Status</th>
            <th>Order Track</th>
            <th>{{__('adminMessage.date')}}</th>
            <!--<th width="10">{{__('adminMessage.actions')}}</th>-->
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @foreach($resources as $resource)
                @php
                    if($resource->is_approved=="approved"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--success"><b>Pay & Approved</b></span>';
                    }
                    elseif($resource->is_approved=="pending"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--warning"><b>Pay & Waiting for approved</b></span>';
                    } elseif($resource->is_approved=="Reject"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger"><b>Pay & Reject</b></span>';
                    } elseif($resource->is_approved=="pending_payment"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger"><b>Not Pay Yet</b></span>';
                    }
                @endphp
                <tr class="search-body">
                    <td>
                        {{$resource->id}}
                    </td>
                    <td>
                        <a href="/gwc/workshops?id={{$resource->workshop_id}}"> {!! $resource->name !!} </a>
                        <a href="/gwc/freelancers?id={{$resource->freelancer_id}}"> <i class="fa fa-user"></i></a>
                        <a href="/gwc/book-details/workshop/{{$resource->id}}"> <i class="fa fa-eye"></i></a>
                    </td>
                    <td>
                        {!! number_format($resource->total_persons) !!}
                    </td>
                    <td>
                        {!! number_format($resource->creat_price) !!}KD
                    </td>
                    <td>
                        {!! $payStatus??'' !!}
                    </td>
                    <td>
                        {!! $resource->order_track !!}
                    </td>
                    <td>
                        {!! $resource->created_at !!}
                    </td>
                </tr>
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