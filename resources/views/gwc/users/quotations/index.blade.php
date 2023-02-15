@extends('gwc.template.ordersIndexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>Freelancer name</th>
            <th>user name</th>
            <th>{{__('adminMessage.description')}}</th>
            <th>{{__('adminMessage.budget')}}</th>
            <th>{{__('adminMessage.place')}}</th>
            <th>{{__('adminMessage.time')}}</th>
            <th>{{__('adminMessage.payment')}}</th>
            <th>{{__('adminMessage.attachment')}}</th>
            <th width="10">{{__('adminMessage.actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($resources))
            @php
                $p=1;
                $orderStatus='';
            @endphp
            @foreach($resources as $resource)
                <tr class="search-body">
                    <td>
                        {{$p}}
                    </td>
                    <td>
                        {!! $resource->freelancer->name !!}
                    </td>
                    <td>
                        {!! $resource->user->first_name.' '.$resource->user->last_name !!}
                    </td>
                    <td>
                        {!! $resource->description !!}
                    </td>
                 

                    <td>
                        {!! $resource->budget !!}
                    </td>
                    <td class="kt-datatable__cell">
                        {!! $resource->place !!}
                    </td>
                    <td class="kt-datatable__cell">
                        {!! $resource->time !!}
                    </td>
                    <td class="kt-datatable__cell">
                        {!! $resource->payment_type !!}
                    </td>
                    <td class="kt-datatable__cell">
                        @foreach(explode(',', $resource->attachment) as $image)
                        @if($image)
                            <div>
                                <form action="{{route('download.quotation')}}">
                                    @csrf
                                    <input type="hidden" name="image" value="{{$image}}">
                            <button type="submit" >download</a>
                            </form>
                            </div>
                            @endif
                        @endforeach
                    </td>
                    <td class="kt-datatable__cell">
                        <span style="overflow: visible; position: relative; width: 80px;">
                            <div class="dropdown">
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                            <li class="kt-nav__item">
                                                <a href="{{url($data['url'] . 'quotation/' . $resource->id)}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon-eye"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.view')}}</span>
                                                </a>
                                            </li>
                                        <li class="kt-nav__item">
                                                <a href="{{url($data['url'] . 'quotation/' . $resource->id)}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon-eye"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.create_payment_link')}}</span>
                                                </a>
                                            </li>
                                        <li class="kt-nav__item">
                                                <a href="{{url($data['url'] . 'quotation/' . $resource->id)}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon-eye"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.payment_logs')}}</span>
                                                </a>
                                            </li>
                                    </ul>
                                </div>
                            </div>
                        </span>
                    </td>
                </tr>
                @php $p++; @endphp
            @endforeach
            <tr>
{{--                <td colspan="9" class="text-center">{{ $resources->links() }}</td>--}}
            </tr>
        @else
            <tr>
                <td colspan="9"
                    class="text-center">{{__('adminMessage.recordnotfound')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection