@extends('gwc.template.indexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.image')}}</th>
            <th>{{__('adminMessage.name')}}</th>
            <th>{{__('adminMessage.price')}}</th>
            <th>is active</th>
            <th width="10">{{__('adminMessage.actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @php $p=1; @endphp
            @foreach($resources as $resource)
                <tr class="search-body">
                    <td>
                        {{$p}}
                    </td>
                    <td>
                        <a href="{{ asset($resource->image) }}" target="_blank">
                            @if( file_exists(public_path($resource->image)) and mime_content_type(public_path($resource->image)) and strstr(mime_content_type(public_path($resource->image)) , "video/") )
                                <video style="width: 80px ;border-radius: 1px">
                                    <source src="{{ $resource->image }}" type="{{ mime_content_type(public_path($resource->image)) }}">
                                </video>
                            @else
                                <img class="p-1" src="{!! $resource->image !!}"
                                     width="40">
                            @endif
                        </a>
                    </td>
                    <td>
                        {!! $resource->name !!}
                    </td>
                    <td>
                        {!! $resource->price !!}
                    </td>
                    <td>
                        <span class="kt-switch">
                            <label>
                                <input type="checkbox" id="service-isactive" class="change_status"
                                       value="{{$resource->id}}" {{!empty($resource->is_active)?'checked':''}}>
                                <span></span>
                            </label>
                        </span>
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
                                        <li class="kt-nav__item">
                                            <a href="/gwc/services-orders?service_id={{$resource->id}}" class="kt-nav__link">
                                                <i class="kt-nav__link-icon fa fa-eye"></i>
                                                <span class="kt-nav__link-text">Booking list</span>
                                            </a>
                                        </li>
                                        @if(auth()->guard('admin')->user()->can($data['editPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{url($data['url'] . $resource->id . '/edit')}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-contract"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.edit')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth()->guard('admin')->user()->can($data['deletePermission']))
                                            <li class="kt-nav__item">
                                                <a href="javascript:;" data-toggle="modal"
                                                   data-target="#kt_modal_{{$resource->id}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-trash"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.delete')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </span>

                        <!--Delete modal -->
                        @component('gwc.templateIncludes.deleteModal', [
							'url' => $data['url'],
							'object' => $resource
						]) @endcomponent
                    </td>
                </tr>
                @php $p++; @endphp
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