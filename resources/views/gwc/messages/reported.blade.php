@extends('gwc.template.indexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>User</th>
            <th>Freelancer</th>
            <th>Report from</th>
            <th>Status</th>
            <th>Created At</th>
            <th>See Messages</th>
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
                        <a href="/gwc/users?id={{ $resource->user_id }}">{{ $resource->user->fullname }}</a>
                    </td>
                    <td>
                        <a href="/gwc/freelancers?id={{ $resource->freelancer_id }}">{{ $resource->freelancer->name }}</a>
                    </td>
                    <td>
                        {{ $resource->sendFrom }}
                    </td>
                    <td>
                        @if ( $resource->status )
                            <span class="text-warning">Checked</span>
                        @else
                            <a href="/gwc/message/reported/{{ $resource->id }}/checked">Mark as checked</a>
                        @endif
                    </td>
                    <td>
                        {{ $resource->created_at }}
                    </td>
                    <td class="kt-datatable__cell">
                        @if ( $resource->sendFrom == "Freelancer")
                            <a href="/gwc/users/{{ $resource->user_id }}/messages?freelancer_id={{ $resource->freelancer_id }}">See message</a>
                        @else
                            <a href="/gwc/freelancers/{{ $resource->freelancer_id }}/messages?user_id={{ $resource->user_id }}">See message</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7" class="text-center">{{ $resources->links() }}</td>
            </tr>
        @else
            <tr>
                <td colspan="7" class="text-center">{{__('adminMessage.recordnotfound')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection