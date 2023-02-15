@extends('gwc.template.indexTemplate' , ['searchBox' => false])

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.name')}}</th>
            <th>people</th>
            <th>order track</th>
            <th>Price</th>
            <th>payment status</th>
            <th>payment id</th>
            <th>payment error</th>
            <th>Details</th>
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @foreach($resources as $resource)
                <tr class="search-body">
                    <td>
                        {{$resource->id}}
                    </td>
                    <td>
                        <a href="/gwc/users/{!! $resource->user->id !!}/edit">
                        {!! $resource->user->first_name !!} {!! $resource->user->last_name !!}
                        </a>
                    </td>
                    <td>
                        {!! $resource->people_count !!}
                    </td>
                    <td>
                        {!! $resource->order_track !!}
                    </td>
                    <td>
                        {{ $resource->amount }} ( commission: {{ $resource->commission }})
                    </td>
                    <td>
                        {{ $resource->payment_status }}
                    </td>
                    <td>
                        {{ $resource->payment_id }}
                    </td>
                    <td>
                        {{ $resource->error }}
                    </td>
                    <td>
                        <a href="/gwc/book-details/workshop/{{ $resource->id }}" >Details</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8"
                    class="text-center">{{__('adminMessage.recordnotfound')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection