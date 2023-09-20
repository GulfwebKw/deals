@extends('gwc.template.indexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">

        <tbody>
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.name')}}</th>
            <th>{{__('adminMessage.email')}}</th>
            <th>{{__('adminMessage.phone')}}</th>
            <th width="10">{{__('adminMessage.actions')}}</th>
        </tr>
        </thead>
        @if(count($resources))
            @foreach($resources as $resource)
                <tr class="search-body">
                    <td>
                        {{$resource->id}}
                    </td>
                    <td>
                        {!! $resource->name !!}
                    </td>
                    <td>
                        {!! $resource->email !!}
                    </td>
                    <td>
                        {!! $resource->phone !!}
                    </td>
                    <td class="kt-datatable__cell">
                        <span style="overflow: visible; position: relative; width: 80px;">
                            <div class="dropdown">
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                   data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        @if(auth()->guard('admin')->user()->can($data['approvedPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{route('approvedFreeLancer' , $resource->id )}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-check-mark text-success"></i>
                                                    <span class="kt-nav__link-text">Approved</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth()->guard('admin')->user()->can($data['rejectPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{route('rejectFreeLancer' , $resource->id )}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-cross text-danger"></i>
                                                    <span class="kt-nav__link-text">Reject</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth()->guard('admin')->user()->can($data['editPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{url('gwc/freelancers/'.$resource->id .'/edit')}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-contract"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.edit')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </span>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-center">{{ $resources->links() }}</td>
            </tr>
        @else
            <tr>
                <td colspan="5"
                    class="text-center">{{__('adminMessage.recordnotfound')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection