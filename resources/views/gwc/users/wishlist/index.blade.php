@extends('gwc.template.indexTemplate')

@section('indexContent')
    <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        <thead>
        <tr>
            <th width="10">#</th>
            <th>{{__('adminMessage.image')}}</th>
            <th>{{__('adminMessage.freelancer_name')}}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($wishlists))
            @php $p=1; @endphp
            @foreach($wishlists as $wishlist)
                <tr class="search-body">
                    <td>
                        {{$p}}
                    </td>
                    <td>
                        @if($wishlist->image)
                            <img width="50" src="{{'/uploads/freelancers/'.$wishlist->image}}" alt="">
                        @endif
                    </td>
                    <td>
                        {{$wishlist->name}}
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