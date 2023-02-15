@extends('gwc.template.editTemplate')
@section('editContent')
<?php
    $country = count($resource->areas)>0?$resource->areas[0]->city->country_id:'';
    $city = count($resource->areas)>0?$resource->areas[0]->city_id:'';
    ?>
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{route($data['updateRoute'],$resource->id)}}">
        @method('PUT')
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Name',
                            'name' => 'name',
                            'value'=>$resource->name,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Email',
                            'name' => 'email',
                            'value'=>$resource->email,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Phone',
                            'name' => 'phone',
                            'value'=>$resource->phone,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Link',
                            'name' => 'link',
                            'value'=>$resource->link,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        @component('gwc.components.editTextarea', [
                                    'label'=> 'Bio',
                                    'name'=> 'bio',
                                    'value'=>$resource->bio
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-5">
                        <!-- image -->
                        @php $label = "Image"; @endphp
                        @php $field = 'image'; @endphp
                        @component('gwc.components.createImageUpload', [
                            'label' => $label,
                            'name' => $field,
                        ]) @endcomponent
                    </div>
                    <div class="col-md-2">
                        <img src="{{'/uploads/'. $data['path']. '/thumb/'.$resource->image}}" alt="">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'service commission price',
                            'name' => 'service_commission_price',
                            'value' => $resource->service_commission_price,
                            'type' => "number",
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        <label>How to use the amount and percentage</label>
                        <span style="color: red">*</span>
                        <select class="form-control" name="service_commission_type">
                            <option value="price" @if( $resource->service_commission_type == 'price' ) selected @endif>Just Price</option>
                            <option value="percent" @if( $resource->service_commission_type == 'percent' ) selected @endif>Just Percent</option>
                            <option value="plus" @if( $resource->service_commission_type == 'plus' ) selected @endif>plus Percent and Price </option>
                            <option value="price" @if( $resource->service_commission_type == 'min' ) selected @endif>Minimum of percent and price</option>
                            <option value="price" @if( $resource->service_commission_type == 'max' ) selected @endif>Maximum of percent and price</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'service commission percent',
                            'name' => 'service_commission_percent',
                            'value' => $resource->service_commission_percent,
                            'type' => "number",
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'workshop commission price',
                            'name' => 'workshop_commission_price',
                            'value' => $resource->workshop_commission_price,
                            'type' => "number",
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        <label>How to use the amount and percentage</label>
                        <span style="color: red">*</span>
                        <select class="form-control" name="workshop_commission_type">
                            <option value="price" @if( $resource->workshop_commission_type == 'price' ) selected @endif>Just Price</option>
                            <option value="percent" @if( $resource->workshop_commission_type == 'percent' ) selected @endif>Just Percent</option>
                            <option value="plus" @if( $resource->workshop_commission_type == 'plus' ) selected @endif>plus Percent and Price </option>
                            <option value="price" @if( $resource->workshop_commission_type == 'min' ) selected @endif>Minimum of percent and price</option>
                            <option value="price" @if( $resource->workshop_commission_type == 'max' ) selected @endif>Maximum of percent and price</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'workshop commission percent',
                            'name' => 'workshop_commission_percent',
                            'value' => $resource->workshop_commission_percent,
                            'type' => "number",
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'bill commission price',
                            'name' => 'bill_commission_price',
                            'value' => $resource->bill_commission_price,
                            'type' => "number",
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        <label>How to use the amount and percentage</label>
                        <span style="color: red">*</span>
                        <select class="form-control" name="bill_commission_type">
                            <option value="price" @if( $resource->bill_commission_type == 'price' ) selected @endif>Just Price</option>
                            <option value="percent" @if( $resource->bill_commission_type == 'percent' ) selected @endif>Just Percent</option>
                            <option value="plus" @if( $resource->bill_commission_type == 'plus' ) selected @endif>plus Percent and Price </option>
                            <option value="price" @if( $resource->bill_commission_type == 'min' ) selected @endif>Minimum of percent and price</option>
                            <option value="price" @if( $resource->bill_commission_type == 'max' ) selected @endif>Maximum of percent and price</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'bill commission percent',
                            'name' => 'bill_commission_percent',
                            'value' => $resource->bill_commission_percent,
                            'type' => "number",
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label>Location type</label>
                    <select name="location_type" onchange="locationtype(this.value)"  class="form-control" >
                        <option value="my" @if($resource->location_type == "my") selected @endif >Freelancer Address</option>
                        <option value="any" @if($resource->location_type == "any") selected @endif >Any Address</option>
                        <option value="both" @if($resource->location_type == "both") selected @endif >Both</option>
                    </select>
                </div>

{{--                <div class="col-md-4 selectarea" >--}}
{{--                    <label>Country</label>--}}
{{--                    <select name="country_id" onchange="getCities(this.value)" id=""  class="form-control" >--}}
{{--                        <option value="">None</option>--}}
{{--                        @foreach($countries as $EachCountry)--}}
{{--                            <option value="{{ $EachCountry->id }}" @if($EachCountry->id==$country) selected @endif>{{ $EachCountry->title_en }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}

                <div class="col-md-6 selectarea">
                    <label>City</label>
                    <select name="city_id" id="city-list" onchange="getAreas(this.value)"  class="form-control" >
                        <option value="">None</option>
                    </select>
                </div>

            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Category</label>
                        <select style="height: 200px" multiple name="category_id[]" class="form-control">
                            <option value="">None</option>
                            @foreach($categories as $category)
                                <option   value="{{ $category->id }}" @if(in_array($category->id, $category_ids->toArray()))  selected @endif>
                                    {{ $category->title }}
                                </option>
                                @if(count($category->childrenRecursive)>0)
                                    @include('gwc.partials.Editcategory',['categories' => $category->childrenRecursive, 'parent_id'=>$category_ids, 'level'=>0,'category_id'=>$resource->category_id])
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 selectarea">
                        <label>Area</label>
                        <select style="height: 200px" name="area_id[]" id="area-list"  class="form-control" multiple >
                            <option value="">None</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="col-auto col-form-label">{{__('adminMessage.isactive')}}</label>
                    <div class="col-auto">
                        @component('gwc.components.editIsActive', [
                            'value' => $resource->is_active
                        ]) @endcomponent
                    </div>

                    <label class="col-auto col-form-label">{{__('adminMessage.quotation')}}</label>
                    <div class="col-auto">
                    <span class="kt-switch">
                         <label>
                             <input type="checkbox" @if($resource->quotation) checked @endif name="quotation" id="is_active"/>
                              <span></span>
                         </label>
                    </span>
                    </div>

                    <label class="col-auto col-form-label">{{__('adminMessage.set_a_meeting')}}</label>
                    <div class="col-auto">
                    <span class="kt-switch">
                         <label>
                             <input type="checkbox" @if($resource->set_a_meeting) checked @endif name="set_a_meeting" id="is_active"/>
                              <span></span>
                         </label>
                    </span>
                    </div>
                </div>
            </div>



        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>

@endsection

@section('script')

    <script>

        function locationtype(val) {
            if ( val !== "my" ){
                $(".selectarea").show();
            } else
                $(".selectarea").hide();
        }
        locationtype("{{$resource->location_type}}");

        function getCities(val) {
            console.log(val)
            $.ajax({
                type: "POST",
                url: "/gwc/get-country-cities",
                data: {country_id: val, id: '{{$resource->city_id}}'},
                beforeSend: function () {
                    $("#city-list").addClass("loader");
                },
                success: function (data) {
                    $("#city-list").html(data);
                    $("#city-list").prop('disabled', false);
                    $("#city-list").removeClass("loader");
                }
            });
        }
        getCities(2);
        function getAreas(val) {
            $.ajax({
                type: "POST",
                url: "/gwc/get-city-areas",
                data: 'city_id=' + val,
                beforeSend: function () {
                    $("#area-list").addClass("loader");
                },
                success: function (data) {
                    $("#area-list").html(data);
                    $("#area-list").prop('disabled', false);
                    $("#area-list").removeClass("loader");
                }
            });
        }
    </script>
    @if($country && $city)
        <script>

            document.addEventListener('DOMContentLoaded', (event) => {
                $.ajax({
                    type: "POST",
                    url: "/gwc/get-country-cities-edit",
                    data: {country_id: @json($country), id: @json($city)},
                    beforeSend: function () {
                        $("#city-list").addClass("loader");
                    },
                    success: function (data) {
                        $("#city-list").html(data);
                        $("#city-list").prop('disabled', false);
                        $("#city-list").removeClass("loader");
                        document.getElementById('city-list').value=@json($city);
                        $.ajax({
                            type: "POST",
                            url: "/gwc/get-city-areas",
                            data: 'city_id=' + @json($city),
                            beforeSend: function () {
                                $("#area-list").addClass("loader");
                            },
                            success: function (data) {
                                $("#area-list").html(data);
                                $("#area-list").prop('disabled', false);
                                $("#area-list").removeClass("loader");
                                var element = document.getElementById('area-list')
                                var values = '{{$area_ids}}'
                                console.log(values)
                                for (var i = 0; i < element.options.length; i++) {
                                    element.options[i].selected = values.indexOf(element.options[i].value) > -1;
                                }
                            }
                        });
                    }
                });
            });

        </script>
    @endif
@endsection