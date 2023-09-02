@extends('gwc.template.indexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.name')}}</th>
            <th>{{__('adminMessage.date')}}</th>
            <th>{{__('adminMessage.price')}}</th>
            <th>{{__('adminMessage.total_persons')}}</th>
            <th width="10">{{__('adminMessage.status')}}</th>
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
                        {!! $resource->name !!}
                    </td>
                    <td>
                        {!! $resource->date !!} ( {{ $resource->from_time }} -  {{ $resource->to_time }} )
                    </td>
                    <td>
                        {!! $resource->price !!}
                    </td>
                    <td>
                        {{ $resource->reserved }} reserved from {!! $resource->total_persons !!}
                    </td>
                    <td>
                        <span class="kt-switch">
                            <label>
                                <input type="checkbox" id="{{ $data['path'] }}" class="change_status"
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
                                            <a href="{{url($data['url'] . $resource->id )}}"
                                               class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-user"></i>
                                                <span class="kt-nav__link-text">Reserved</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="{{url('gwc/make-workshop-orders?id=' . $resource->id )}}"
                                               class="kt-nav__link">
                                                <i class="kt-nav__link-icon fas fa-file-invoice-dollar"></i>
                                                <span class="kt-nav__link-text">Workshop Invoice</span>
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