@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data" action="{{route($data['storeRoute'])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- name -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'First Name',
                            'name' => 'first_name',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Last Name',
                            'name' => 'last_name',
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <!-- email -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Email',
                            'name' => 'email',
                            'type' => 'email',
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <!-- auth -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Mobile',
                            'name' => 'mobile',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Password',
                            'name' => 'password',
                            'type' => 'password',
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <!-- gender birthday -->
{{--            <div class="form-group">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        @component('gwc.components.createTextInput', [--}}
{{--                            'label' => 'Birthday',--}}
{{--                            'name' => 'birthday',--}}
{{--                            'required' => true--}}
{{--                        ]) @endcomponent--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <label>Gender</label>--}}
{{--                        <select name="gender" class="form-control" required>--}}
{{--                            <option value="male" selected>Male</option>--}}
{{--                            <option value="female">Female</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <br><br>--}}

{{--            <!-- country city area -->--}}
{{--            <div class="form-group">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-4">--}}
{{--                        <label>Country</label>--}}
{{--                        <span style="color: red">*</span>--}}
{{--                        <select name="country" id="country-list" class="form-control" onChange="getCities(this.value);" required>--}}
{{--                            <option value="" disabled selected>Select Country</option>--}}
{{--                            @foreach($countries as $country)--}}
{{--                                <option value="{{$country->id}}" >--}}
{{--                                    {{$country->title_en}}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <label>City</label>--}}
{{--                        <span style="color: red">*</span>--}}
{{--                        <select name="city" id="city-list" class="form-control" onChange="getAreas(this.value);" required disabled>--}}
{{--                            <option value="" disabled>Select City</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <label>Area</label>--}}
{{--                        <span style="color: red">*</span>--}}
{{--                        <select name="area" id="area-list" class="form-control" required disabled>--}}
{{--                            <option value="" disabled>Select Area</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- address -->--}}
{{--            <div class="form-group">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-4">--}}
{{--                        @component('gwc.components.createTextInput', [--}}
{{--                            'label' => 'Block',--}}
{{--                            'name' => 'block',--}}
{{--                            'required' => true--}}
{{--                        ]) @endcomponent--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        @component('gwc.components.createTextInput', [--}}
{{--                            'label' => 'Street',--}}
{{--                            'name' => 'street',--}}
{{--                            'required' => true--}}
{{--                        ]) @endcomponent--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        @component('gwc.components.createTextInput', [--}}
{{--                            'label' => 'Avenue',--}}
{{--                            'name' => 'avenue',--}}
{{--                            'required' => true--}}
{{--                        ]) @endcomponent--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- address -->--}}
{{--            <div class="form-group">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        @component('gwc.components.createTextInput', [--}}
{{--                            'label' => 'House No',--}}
{{--                            'name' => 'house_no',--}}
{{--                            'required' => true--}}
{{--                        ]) @endcomponent--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        @component('gwc.components.createTextInput', [--}}
{{--                            'label' => 'Flat',--}}
{{--                            'name' => 'flat',--}}
{{--                            'required' => true--}}
{{--                        ]) @endcomponent--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <br><br>--}}

{{--            <div class="form-group">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-6">--}}
{{--                        <!-- image -->--}}
{{--                        @php $label = "Image"; @endphp--}}
{{--                        @php $field = 'image'; @endphp--}}
{{--                        @component('gwc.components.createImageUpload', [--}}
{{--                            'label' => $label,--}}
{{--                            'name' => $field,--}}
{{--                            'required' => true--}}
{{--                        ]) @endcomponent--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-6">--}}
                        <div class="form-group row">
                            <!-- is active? -->
                            <label class="col-3 col-form-label">{{__('adminMessage.isactive')}}</label>
                            <div class="col-3">
                                @component('gwc.components.createIsActive') @endcomponent
                            </div>

{{--                            <!-- newsletter? -->--}}
{{--                            <label class="col-3 col-form-label">Newsletter?</label>--}}
{{--                            <div class="col-3">--}}
{{--                                <span class="kt-switch">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" checked="checked" name="newsletter"  id="newsletter" value="1"/>--}}
{{--                                        <span></span>--}}
{{--                                    </label>--}}
{{--                                </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>

    <script>
        function getCities(val) {
            $.ajax({
                type: "POST",
                url: "/gwc/get-country-cities",
                data:'country_id='+val,
                beforeSend: function() {
                    $("#city-list").addClass("loader");
                },
                success: function(data){
                    $("#city-list").html(data);
                    $("#city-list").prop('disabled', false);
                    $("#city-list").removeClass("loader");
                }
            });
        }

        function getAreas(val) {
            $.ajax({
                type: "POST",
                url: "/gwc/get-city-areas",
                data:'city_id='+val,
                beforeSend: function() {
                    $("#area-list").addClass("loader");
                },
                success: function(data){
                    $("#area-list").html(data);
                    $("#area-list").prop('disabled', false);
                    $("#area-list").removeClass("loader");
                }
            });
        }
    </script>

@endsection