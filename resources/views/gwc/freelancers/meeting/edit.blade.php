@extends('gwc.template.editTemplate')

@section('editContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{'/gwc/freelancer/'. Request::segment(3).'/meetings/' . Request::segment(5)}}">
        @method('PUT')
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- email -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Slot</label>
                        <select name="slot" class="form-control"
                                required>
                            @foreach($slots as $slot)
                                <option value="{{$slot->id}}">{{$slot->date}} {{$slot->start_time}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Location</label>
                        <select name="location" id="user_id-list" class="form-control"
                                required>
                            @foreach($locations as $location)
                                <option value="{{ isset($location['user_id']) ? 'user' : 'freelancer' }}_{{$location['id']}}">@if(isset($location['user_id'])) user: @else freelancer: @endif {{$location['full_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>


        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection
