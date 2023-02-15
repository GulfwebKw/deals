@extends('gwc.template.orders2IndexTemplate')

@section('indexContent')

    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>Freelancer Name</th>
            <th>{{__('adminMessage.date')}}</th>
            <th>{{__('adminMessage.package_name')}}</th>
            <th>Booked At</th>
            <th>{{__('adminMessage.status')}}</th>
            <!--<th>{{__('adminMessage.total')}}</th>
            <th>{{__('adminMessage.payment_id')}}</th>
            <th>{{__('adminMessage.pay_status')}}</th>-->
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
                        <a href="/gwc/freelancers?id={{$resource->freelancer_id}}">{!!$resource->freelancer_name!!}</a>
                    </td>
                    <td>
                        {!! $resource->date !!} {!! $resource->time !!}
                    </td>
                    <td>
                        <b>{{$resource->type}}:</b> {{ $resource->packageName }}<br>
                        <a href="/gwc/book-details/{{$resource->type}}/{{ $resource->id }}" >Details</a>
                    </td>
                    <td>
                        {!! $resource->created_at !!}
                    </td>
                    <td>
                        {!! $resource->status !!}
                    </td>
                    <!--<td>
                        {!! $resource->amount !!}
                    </td>
                    <td>
                        {!! $resource->payment_id !!}
                    </td>
                    <td>
                        {!! $resource->payment_status !!}
                    </td>-->
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