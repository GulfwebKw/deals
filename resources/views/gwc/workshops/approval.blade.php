@extends('gwc.template.indexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">

        <tbody>
        @if(count($resources))
            @foreach($resources as $resource)
                <thead>
                <tr>
                    <th width="10">#</th>
                    <th>{{__('adminMessage.image')}}</th>
                    <th>{{__('adminMessage.workshop_name')}}</th>
                    <th>{{__('adminMessage.freelancer_name')}}</th>
                    <th>{{__('adminMessage.availability')}}</th>
                    <th>Num. Person</th>
                    <th width="10">{{__('adminMessage.actions')}}</th>
                </tr>
                </thead>
                <tr class="search-body">
                    <td rowspan="3">
                        {{$resource->id}}
                    </td>
                    <td>
                        <img class="p-1" src="{!! $resource->images !!}" width="100px">
                                
                    </td>
                    <td>
                        {!! $resource->name !!}
                    </td>
                    <td>
                        <a href="/gwc/freelancers?id={{ $resource->freelancer_id}}"> {!! $resource['freelancer']->name !!}</a>
                    </td>
                    <td>
                        {!! $resource->date !!} from {!! $resource->from_time !!} to {!! $resource->to_time !!}
                    </td>
                    <td>
                        {{ $resource->total_persons }}
                    </td>
                    <td class="kt-datatable__cell"  rowspan="3">
                        <span style="overflow: visible; position: relative; width: 80px;">
                            <div class="dropdown">
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                   data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__item">
                                            <a href="{{url('gwc/make-workshop-orders?id=' . $resource->id )}}"
                                               class="kt-nav__link">
                                                <i class="kt-nav__link-icon fas fa-file-invoice-dollar"></i>
                                                <span class="kt-nav__link-text">Workshop Invoice</span>
                                            </a>
                                        </li>
                                        @if(auth()->guard('admin')->user()->can($data['approvedPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{route('approvedWorkshop' , $resource->id )}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-check-mark text-success"></i>
                                                    <span class="kt-nav__link-text">Approved</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth()->guard('admin')->user()->can($data['rejectPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{route('rejectWorkshop' , $resource->id )}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-cross text-danger"></i>
                                                    <span class="kt-nav__link-text">Reject</span>
                                                </a>
                                            </li>
                                        @endif
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
                <tr>
                    <th colspan="2">Address</th>
                    <th colspan="2">Description</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td colspan="2">
                        {{ $resource->area->title_en }}. Block:{{ $resource->block }}.
                        Street:{{ $resource->street }}.
                        building:{{ $resource->building_name }} ( {{ $resource->apartment_no }} ).
                        Floor:{{ $resource->floor }}
                    </td>
                    <td colspan="2">{!! $resource->description !!}</td>
                    <td>{{ $resource->price }}</td>
                </tr>
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