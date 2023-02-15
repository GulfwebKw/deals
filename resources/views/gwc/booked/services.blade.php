@extends('gwc.template.orders4IndexTemplate')

@section('searchHeader')
    <!-- order status -->
    <div class="btn-group mx-2">
        <button type="button" class="btn btn-primary btn-bold dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            @if(Request()->input('status')){{strtoupper(Request()->input('status'))}}@else{{strtoupper(__('adminMessage.all'))}}@endif
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <ul class="kt-nav">
                <li class="kt-nav__item"><a href="{{request()->fullUrlWithQuery(['status' => 'all'])}}" class="kt-nav__link" id="all">{{__('adminMessage.all')}}</a></li>
                <li class="kt-nav__item"><a href="{{request()->fullUrlWithQuery(['status' => 'reschedule'])}}" class="kt-nav__link" id="waiting">Reschedule</a></li>
                <li class="kt-nav__item"><a href="{{request()->fullUrlWithQuery(['status' => 'cancel'])}}" class="kt-nav__link" id="cancel">Cancel</a></li>
                <li class="kt-nav__item"><a href="{{request()->fullUrlWithQuery(['status' => 'completed'])}}" class="kt-nav__link" id="paid">Completed</a></li>
                <li class="kt-nav__item"><a href="{{request()->fullUrlWithQuery(['status' => 'booked'])}}" class="kt-nav__link" id="paid">Booked</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('indexContent')

    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>Id</th>
            <th>User</th>
            <th>Freelancer</th>
            <th>Service</th>
            <th>Rate</th>
            <th>Date</th>
            <th>People</th>
            <th>Status</th>
            <th width="10">{{__('adminMessage.actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @foreach($resources as $resource)
                @php
                    if($resource->order->payment_status=="paid"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--success"><b>Paid</b></span>';
                    }
                    elseif($resource->order->payment_status=="waiting"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--warning"><b>Waiting</b></span>';
                    } elseif($resource->order->payment_status=="cancel"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger"><b>Cancel</b></span>';
                    }
                @endphp
                <tr class="search-body">
                    <td>
                        <span onclick="$('.moreDetails_{{ $resource->id }}').toggle();$('.moreDetails_{{ $resource->id }}_angel').toggle();" style="cursor: pointer;">
                            <i class="fa fa-angle-down moreDetails_{{ $resource->id }}_angel"></i>
                            <i class="fa fa-angle-up moreDetails_{{ $resource->id }}_angel" style="display: none;"></i>
                        </span>
                    </td>
                    <td>
                        {{$resource->id}}
                    </td>
                    <td>
                        <a href="/gwc/users?id={{$resource->order->user_id}}"> {!! $resource->order->user? $resource->order->user->fullname :' [unKnow] ' !!} </a>
                    </td>
                    <td>
                        <a href="/gwc/freelancers?id={{$resource->freelancer_id}}"> {!! $resource->freelancer? $resource->freelancer->name:' [unKnow] ' !!} </a>
                    </td>
                    <td>
                        {{ $resource->service? $resource->service->name:' [unKnow] '  }}
                    </td>
                    <td>
                        @if ( $resource->rate == null )
                            --
                        @elseif( $resource->rate >= 4 )
                            <i class="fa fa-star text-success"></i> {{ $resource->rate }}
                        @elseif( $resource->rate >= 2 )
                            <i class="fa fa-star text-warning"></i> {{ $resource->rate }}
                        @elseif( $resource->rate >= 0 )
                            <i class="fa fa-star text-danger"></i> {{ $resource->rate }}
                        @endif
                    </td>
                    <td>
                        {!! $resource->date !!}
                    </td>
                    <td>
                        {!! $resource->people !!}
                    </td>
                    <td>
                        @if($resource->status=="preorder")
                            <span class="kt-badge kt-badge--inline kt-badge--success"><b>Preorder</b></span>
                        @elseif($resource->status=="booked")
                            <span class="kt-badge kt-badge--inline kt-badge--warning"><b>Booked</b></span>
                        @elseif($resource->status=="freelancer_reschedule")
                            <span class="kt-badge kt-badge--inline kt-badge--warning"><b>F.Reschedule</b></span>
                        @elseif($resource->status=="freelancer_cancel")
                            <span class="kt-badge kt-badge--inline kt-badge--danger"><b>F.Cancel</b></span>
                        @elseif($resource->status=="freelancer_not_available")
                            <span class="kt-badge kt-badge--inline kt-badge--danger"><b>F.Not Available</b></span>
                        @elseif($resource->status=="user_reschedule")
                            <span class="kt-badge kt-badge--inline kt-badge--warning"><b>U.Reschedule</b></span>
                        @elseif($resource->status=="user_cancel")
                            <span class="kt-badge kt-badge--inline kt-badge--danger"><b>U.Cancel</b></span>
                        @elseif($resource->status=="user_not_available")
                            <span class="kt-badge kt-badge--inline kt-badge--danger"><b>U.Not Available</b></span>
                        @elseif($resource->status=="admin_reschedule")
                            <span class="kt-badge kt-badge--inline kt-badge--warning"><b>A.Reschedule</b></span>
                        @elseif($resource->status=="admin_cancel")
                            <span class="kt-badge kt-badge--inline kt-badge--danger"><b>A.Cancel</b></span>
                        @elseif($resource->status=="completed")
                            <span class="kt-badge kt-badge--inline kt-badge--success"><b>Completed</b></span>
                        @elseif($resource->status=="not_pay")
                            <span class="kt-badge kt-badge--inline kt-badge--success"><b>Waiting For Pay</b></span>
                        @endif
                    </td>
                    <td>
                        <span style="overflow: visible; position: relative; width: 80px;">
                            <div class="dropdown">
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__item">
                                            <a href="/gwc/book-details/service/{{ $resource->id }}"  class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon-visible"></i>
                                                <span class="kt-nav__link-text">Details</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="/gwc/services-orders/{{ $resource->order_id }}/details" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-contract"></i>
                                                <span class="kt-nav__link-text">Order</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </span>
                    </td>
                </tr>
                <tr class="moreDetails moreDetails_{{ $resource->id }} bg-secondary shadow" style="display: none;">
                    <td colspan="4">
                        Time: {{ $resource->date }} {{ $resource->time }}
                    </td>
                    <td colspan="2">
                        Pay: {!! $payStatus !!}
                    </td>
                    <td colspan="2">
                        F.Earn: {{ $resource->earn }}
                    </td>
                    <td colspan="2">
                        Commission: {{ $resource->commission }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="10" class="text-center">{{ $resources->links() }}</td>
            </tr>
        @else
            <tr>
                <td colspan="10"
                    class="text-center">{{__('adminMessage.recordnotfound')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection