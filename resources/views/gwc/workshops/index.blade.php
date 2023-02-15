@extends('gwc.template.indexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.image')}}</th>
            <th>{{__('adminMessage.workshop_name')}}</th>
            <th>{{__('adminMessage.freelancer_name')}}</th>
            <th>{{__('adminMessage.availability')}}</th>
            <th>{{__('adminMessage.active')}}</th>
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
                        <img class="p-1" src="{!! $resource->images !!}"width="40">
                                
                    </td>
                    <td>
                        {!! $resource->name !!}
                    </td>
                    <td>
                        <a href="/gwc/freelancers?id={{ $resource->freelancer_id}}"> {!! $resource['freelancer']->name !!}</a>
                    </td>
                    <td>
                        {!! $resource->date !!} {!! $resource->from_time !!} - {!! $resource->to_time !!}
                    </td>
                    <td>
                         <span class="kt-list-timeline__time">
                                                        <span class="kt-switch"><label><input value="{{$resource->id}}"
                                                                                              {{!empty($resource->is_active)?'checked':''}} type="checkbox"
                                                                                              id="freelancer_workshops"
                                                                                              class="change_status"><span></span></label></span>
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
                                            <a href="{{url('gwc/freelancer/'.$resource->freelancer_id.'/workshop/' . $resource->id )}}"
                                               class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-user"></i>
                                                <span class="kt-nav__link-text">Reserved</span>
                                            </a>
                                        </li>
                                        @if(auth()->guard('admin')->user()->can($data['editPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{url('gwc/freelancer/'.$resource->freelancer_id.'/workshop/' . $resource->id .'/edit')}}"
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
							'url' => 'gwc/freelancer/'.$resource->freelancer_id.'/workshop/' ,
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