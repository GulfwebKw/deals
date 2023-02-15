<table class="table table-borderless table-center" id="kt_table_1">
    <tbody>
        <tr>
            <td>
                Date: {{ $resource->date }}
            </td>
            <td>
                Payment type: {{ $resource->payment_type }}
            </td>
        </tr>
        <tr>
            <td>
                Location type: {{ $resource->location_type }}
            </td>
            <td>
                Created at : {{ $resource->created_at }}
            </td>
        </tr>
    </tbody>
</table>
<table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
    <thead>
    <tr>
        <th width="10">#</th>
        <th>{{__('adminMessage.name')}}</th>
        <th>{{__('adminMessage.description')}}</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
        @php
            $p=1;
        @endphp
        @foreach($resource->services as $service)
            <tr class="search-body">
                <td>
                    {{$p}}
                </td>
                <td>
                    {!! $service->name !!}
                </td>
                <td>
                    {!! $service->description !!}
                </td>
                <td>
                    {!! $service->quantity !!}
                </td>
                <td>
                    {!! $service->price !!}
                </td>
            </tr>
            @php $p++; @endphp
        @endforeach
    </tbody>
</table>