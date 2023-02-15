@extends('gwc.template.indexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.image')}}</th>
            <th>{{__('adminMessage.service_name')}}</th>
            <th>{{__('adminMessage.freelancer_name')}}</th>
            <th>{{__('adminMessage.price')}}</th>
            <th>Category</th>
            <th>{{__('adminMessage.active')}}</th>
            <th>{{__('adminMessage.actions')}}</th>
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
                        <img class="p-1" src="{!! $resource->image !!}"
                                                                     width="40">
                    </td>
                    <td>
                        {!! $resource->name !!}
                    </td>
                    <td>
                        <a href="/gwc/freelancers?id={{$resource['freelancer']->id}}">{!! $resource['freelancer']->name !!}</a>
                    </td>
                    <td>
                        {!! $resource->price !!}
                    </td>
                    <td>
                        {!! $resource['category']->title !!}
                    </td>
                    <td>
                         <span class="kt-list-timeline__time">
                                                        <span class="kt-switch"><label><input value="{{$resource->id}}"
                                                                                              {{!empty($resource->is_active)?'checked':''}} type="checkbox"
                                                                                              id="service-isactive"
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
                                            <a href="/gwc/services-orders?service_id={{$resource->id}}" class="kt-nav__link">
                                                <i class="kt-nav__link-icon fa fa-eye"></i>
                                                <span class="kt-nav__link-text">Booking list</span>
                                            </a>
                                        </li>
                                        @if(auth()->guard('admin')->user()->can('freelancers-edit'))
                                            <li class="kt-nav__item">
                                                <a href="/gwc/freelancer/{{ $resource['freelancer']->id }}/services/{{ $resource->id }}/edit"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-contract"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.edit')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth()->guard('admin')->user()->can('freelancers-delete'))
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
							'url' => '/gwc/freelancer/'.$resource['freelancer']->id.'/services/',
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