@extends('gwc.template.indexTemplate')

@section('indexContent')

    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
        <thead>
        <tr>
            <th>#</th>
            <th>{{__('adminMessage.message')}}</th>
            <th>{{__('adminMessage.createdby')}}</th>
            <th>{{__('adminMessage.createdat')}}</th>
            <th>{{__('adminMessage.actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @php $p=1; @endphp
            @foreach($resources as $resource)
                @php
                    $createdBy = App\Http\Controllers\Common::createdByName($resource->created_by);
                @endphp
                <tr class="search-body">
                    <td>{{$p}}</td>
                    <td>{!! $resource->message !!}</td>
                    <td>{{$createdBy}}</td>
                    <td>{{ \Carbon\Carbon::parse($resource->created_at)->diffForHumans() }}</td>
                    <td class="kt-datatable__cell">
                        @if(auth()->guard('admin')->user()->can($data['deletePermission']))
                            <a title="{{__('adminMessage.delete')}}" href="javascript:;" data-toggle="modal"
                               data-target="#kt_modal_{{$resource->id}}" class="kt-nav__link">
                                <i class="kt-nav__link-icon flaticon2-trash"></i>
                            </a>
                        @endif

                        <!--Delete modal -->
                        @component('gwc.templateIncludes.deleteModal', [
                            'url' => $data['url'],
                            'object' => $resource
                        ]) @endcomponent
                    </td>
                </tr>
                @php $p++; @endphp
            @endforeach
            <tr>
                <td colspan="9" class="text-center">{{$resources->links()}}</td>
            </tr>
        @else
            <tr><td colspan="9" class="text-center">{{__('adminMessage.recordnotfound')}}</td></tr>
        @endif
        </tbody>
    </table>

@endsection