@extends('gwc.template.freelancerIndexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.icon')}}</th>
            <th>{{__('adminMessage.name')}}</th>
            <th>{{__('adminMessage.email')}}</th>
            <th>{{__('adminMessage.phone')}}</th>
            <th>{{__('adminMessage.rate')}}</th>
            <th>Expire At</th>
            <th width="10">{{__('adminMessage.status')}}</th>
            <th width="10">{{__('adminMessage.offline')}}</th>
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
                        <img width="30" src="{{$resource->image}}" alt="">
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
                    <td>
                        @if ( (float)$resource['rate']->rate == null )
                            --
                        @elseif( (float)$resource['rate']->rate >= 4 )
                            <i class="fa fa-star text-success"></i> <b>{{number_format((float)$resource['rate']->rate, 1, '.', '')}}</b>
                        @elseif( (float)$resource['rate']->rate >= 2 )
                            <i class="fa fa-star text-warning"></i> <b>{{number_format((float)$resource['rate']->rate, 1, '.', '')}}</b>
                        @elseif((float)$resource['rate']->rate >= 0 )
                            <i class="fa fa-star text-danger"></i> <b>{{number_format((float)$resource['rate']->rate, 1, '.', '')}}</b>
                        @endif
                    </td>
                    <td>
                        {{$resource->expiration_date}}</b>
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

                    <td>
                        <span class="kt-switch">
                            <label>
                                <input type="checkbox" id="freelancers/offline" class="change_status"
                                       value="{{$resource->id}}" {{!empty($resource->offline)?'checked':''}}>
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
                                        @if(auth()->guard('admin')->user()->can($data['editPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{url($data['url'] . $resource->id . '/edit')}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-contract"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.edit')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                            <li class="kt-nav__item">
                                                <a href="{{url(route('order.bill', ['freelancer_id'=>$resource->id]))}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-tag"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.bills')}}</span>
                                                     </a>
                                            </li>
                                        <li class="kt-nav__item">
                                                <a href="{{'/gwc/freelancer/' .  $resource->id . '/calendar'}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-calendar"></i>
                                                    <span class="kt-nav__link-text">Calendar</span>
                                                </a>
                                        </li>
                                                      <li class="kt-nav__item">
                                                <a href="{{url($data['url'] .  $resource->id . '/highlights')}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-location"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.highlight')}}</span>
                                                </a>
                                        </li>
                                        <li class="kt-nav__item">
                                                <a href="{{url($data['url'] .  $resource->id . '/address')}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-location"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.address')}}</span>
                                                </a>
                                        </li>
                                                  <li class="kt-nav__item">
                                                <a href="{{'/gwc/freelancer/' .  $resource->id . '/meetings'}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-group"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.meeting')}}</span>
                                                </a>
                                        </li>
                                         <li class="kt-nav__item">
                                                <a href="{{'/gwc/freelancer/' . $resource->id . '/services'}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-contract"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.service')}}</span>
                                                </a>
                                            </li>
                                            
                                            <li class="kt-nav__item">
                                                <a href="/gwc/services-orders?freelancer_id={{$resource->id}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-contract"></i>
                                                    <span class="kt-nav__link-text">service Booking list</span>
                                                </a>
                                            </li>
                                            <li class="kt-nav__item">
                                                <a href="{{'/gwc/freelancer/' . $resource->id . '/workshop'}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-time"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.workshop')}}</span>
                                                </a>
                                            </li>

                                            <li class="kt-nav__item">
                                                <a href="{{url('gwc/make-workshop-orders?freelancer_id=' . $resource->id )}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon fas fa-file-invoice-dollar"></i>
                                                    <span class="kt-nav__link-text">Workshops Invoice</span>
                                                </a>
                                            </li>
                                          <li class="kt-nav__item">
                                                <a href="{{url($data['url'] .  $resource->id . '/messages')}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-chat-1"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.messages')}}</span>
                                                </a>
                                            </li>
                                              <li class="kt-nav__item">
                                                <a href="{{url($data['url'] .  $resource->id . '/payments')}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon fas fa-file-invoice-dollar"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.payment_logs')}}</span>
                                                </a>
                                            </li>
                                            @if(auth()->guard('admin')->user()->can($data['deletePermission']) and false)
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
@stop

@section('script')
    <script>
        function categoryChange(value) {
            $.ajax({
                type: "POST",
                url: "/gwc/filter-freelancer-by-category",
                data: 'id=' + value,
                beforeSend: function () {
                    $("#category_change").addClass("loader");
                },
                success: function (data) {
                    console.log(data)
                    // $("#city-list").html(data);
                    // $("#city-list").prop('disabled', false);
                    $("#city-list").removeClass("loader");
                }
            });
        }


    </script>
@endsection