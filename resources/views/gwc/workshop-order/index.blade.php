@extends('gwc.template.orders3IndexTemplate')

@section('indexContent')

    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>User</th>
            <th>{{__('adminMessage.workshop_name')}}</th>
            <th>Number Of people</th>
            <th>{{__('adminMessage.total')}}</th>
            <th>Earn</th>
            <th>commission</th>
            <th>{{__('adminMessage.pay_status')}}</th>
            <th>Order Track</th>
            <th>{{__('adminMessage.date')}}</th>
            <!--<th width="10">{{__('adminMessage.actions')}}</th>-->
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @php
                $p=1;
            @endphp
            @foreach($resources as $resource)
                @php
                    if($resource->payment_status=="paid"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--success"><b>Paid</b></span>';
                    }
                    elseif($resource->payment_status=="waiting"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--warning"><b>Waiting</b></span>';
                    } elseif($resource->payment_status=="cancel"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger"><b>Cancel</b></span>';
                    } elseif($resource->payment_status=="freelancer_cancel"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger"><b>Cancel By Freelancer</b></span>';
                    }
                @endphp
                <tr class="search-body">
                    <td>
                        {{$p}}
                    </td>
                    <td>
                        <a href="/gwc/users/{{$resource->user_id}}/edit"> {!! $resource->user? $resource->user->first_name .' '. $resource->user->last_name :' [unKnow] ' !!} </a>
                    </td>
                    <td>
                        <a href="/gwc/workshops?id={{$resource->workshop_id}}"> {!! $resource->workshop?$resource->workshop->name:' [unKnow] ' !!} </a>
                        <a href="/gwc/freelancers?id={{$resource->freelancer_id}}"> <i class="fa fa-user"></i></a>
                        <a href="/gwc/book-details/workshop/{{$resource->id}}"> <i class="fa fa-eye"></i></a>
                    </td>
                    <td>
                        {!! $resource->people_count !!}
                    </td>
                    <td>
                        {!! $resource->amount !!}
                    </td>
                    <td>
                        {!! $resource->earn !!}
                    </td>
                    <td>
                        {!! $resource->commission !!}
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