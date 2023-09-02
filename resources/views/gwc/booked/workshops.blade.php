@extends('gwc.template.orders4IndexTemplate')

@section('searchHeader')
    <!-- order status -->
    <div class="btn-group mx-2">
        <button type="button" class="btn btn-primary btn-bold dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            @if(Request()->input('payment_status')){{strtoupper(Request()->input('payment_status'))}}@else{{strtoupper(__('adminMessage.all'))}}@endif
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <ul class="kt-nav">
                <li class="kt-nav__item"><a href="{{request()->fullUrlWithQuery(['payment_status' => 'all'])}}" class="kt-nav__link" id="all">{{__('adminMessage.all')}}</a></li>
                <li class="kt-nav__item"><a href="{{request()->fullUrlWithQuery(['payment_status' => 'waiting'])}}" class="kt-nav__link" id="waiting">Waiting</a></li>
                <li class="kt-nav__item"><a href="{{request()->fullUrlWithQuery(['payment_status' => 'cancel'])}}" class="kt-nav__link" id="cancel">Cancel</a></li>
                <li class="kt-nav__item"><a href="{{request()->fullUrlWithQuery(['payment_status' => 'paid'])}}" class="kt-nav__link" id="paid">Paid</a></li>
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
            <th>Workshop</th>
            <th>People</th>
            <th>Status</th>
            <th width="10">{{__('adminMessage.actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @foreach($resources as $resource)
                @php
                    if($resource->payment_status=="paid"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--success"><b>Paid</b></span>';
                    }
                    elseif($resource->payment_status=="waiting"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--warning"><b>Waiting</b></span>';
                    } elseif($resource->payment_status=="cancel"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger"><b>Cancel</b></span>';
                    } elseif($resource->payment_status=="freelancer_cancel"){
                        $payStatus ='<span class="kt-badge kt-badge--inline kt-badge--danger"><b>Cancel By Freelancer</b></span>';
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
                        <a href="/gwc/users?id={{$resource->user_id}}"> {!! $resource->user? $resource->user->fullname :' [unKnow] ' !!} </a>
                    </td>
                    <td>
                        <a href="/gwc/freelancers?id={{$resource->freelancer_id}}"> {!! $resource->freelancer? $resource->freelancer->name:' [unKnow] ' !!} </a>
                    </td>
                    <td>
                        {{ $resource->workshop? $resource->workshop['name'] :' [unKnow] '  }}
                    </td>
                    <td>
                        {!! $resource->people_count !!}
                    </td>
                    <td>
                        {!! $payStatus !!}
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
                                            <a href="/gwc/book-details/workshop/{{ $resource->id }}"  class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon-visible"></i>
                                                <span class="kt-nav__link-text">Details</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="/gwc/workshops-orders/{{ $resource->order_id }}/details" class="kt-nav__link">
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
                        Time: {{ $resource->workshop->date }} From : {{ $resource->workshop->from_time }} until: {{ $resource->workshop->to_time }}
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