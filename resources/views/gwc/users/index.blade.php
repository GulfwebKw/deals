@extends('gwc.template.indexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.image')}}</th>
            <th>{{__('adminMessage.firstname')}}</th>
            <th>{{__('adminMessage.lastname')}}</th>
            <th>{{__('adminMessage.mobile')}}</th>
            <th width="10">{{__('adminMessage.status')}}</th>
            <th width="100">{{__('adminMessage.createdat')}}</th>
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
                        @if($resource->image)
                            <img src="{!! $resource->image !!}" width="40">
                        @endif
                    </td>
                    <td>
                        {!! $resource->first_name !!}
                    </td>
                    <td>
                        {!! $resource->last_name !!}
                    </td>
                    <td>
                        {!! $resource->mobile !!}
                    </td>
                    <td>
                        <span class="kt-switch">
                            <label>
                                <input type="checkbox" id="{{ $data['path'] }}" class="change_status"
                                       value="{{$resource->id}}" {{$resource->is_active?'checked':''}}>
                                <span></span>
                            </label>
                        </span>
                    </td>
                    <td>
                        {!! $resource->created_at !!}
                    </td>
                    <td class="kt-datatable__cell">
                        <span style="overflow: visible; position: relative; width: 80px;">
                            <div class="dropdown">
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        @if(auth()->guard('admin')->user()->can($data['editPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{url($data['url'] . $resource->id . '/edit')}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-contract"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.edit')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                                 <li class="kt-nav__item">
                                                <a href="{{url(route('order.bill', ['user_id'=>$resource->id]))}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-tag"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.bills')}}</span>
                                                </a>
                                            </li>
                                            <li class="kt-nav__item">
                                                <a href="{{url($data['url'] .  $resource->id . '/address')}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-location"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.address')}}</span>
                                                </a>
                                            </li>
                                            <li class="kt-nav__item">
                                                <a href="{{route('user.calenders.index' , [ $resource->id])}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-calendar"></i>
                                                    <span class="kt-nav__link-text">Calendar</span>
                                                </a>
                                            </li>
                                            <li class="kt-nav__item">
                                                <a href="{{url($data['url'] .  $resource->id . '/orders')}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-shopping-cart"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.order_history')}}</span>
                                                </a>
                                            </li>
                                            <li class="kt-nav__item">
                                                <a href="{{url($data['url'] .  $resource->id . '/messages')}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-chat-1"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.messages')}}</span>
                                                </a>
                                            </li>
                                            @if(auth()->guard('admin')->user()->can($data['deletePermission']) and false)
                                                <li class="kt-nav__item">
                                                    <a href="javascript:;" data-toggle="modal" data-target="#kt_modal_{{$resource->id}}" class="kt-nav__link">
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
            <tr>
                <td colspan="8" class="text-center">{{ $resources->links() }}</td>
            </tr>
        @else
            <tr>
                <td colspan="8"
                    class="text-center">{{__('adminMessage.recordnotfound')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection