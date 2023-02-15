@extends('gwc.template.editTemplate')

@section('editContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{'/gwc/users/'. Request::segment(3).'/address/'. Request::segment(5)}}">
        @method('PUT')
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- name -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Name',
                            'name' => 'full_name',
                            'value'=> $resource->full_name,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        <label>Country</label>
                        <select name="country_id" onchange="getCities(this.value)" id="" class="form-control" required>
                            <option value="">None</option>
                            @foreach($countries as $country)
                                <option @if($country->id==$resource->country_id) selected @endif value="{{ $country->id }}">{{ $country->title_en }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- email -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>City</label>
                        <select name="city_id" id="city-list" onchange="getAreas(this.value)" class="form-control"
                                required>
                            <option value="">None</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Area</label>
                        <select name="area_id" id="area-list" class="form-control" required>
                            <option value="">None</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Block',
                            'name' => 'block',
                                                        'value'=> $resource->block,

                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Street',
                            'name' => 'street',
                                                                                    'value'=> $resource->street,

                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Avenue',
                            'name' => 'avenue',
  'value'=> $resource->avenue,

                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'House/Apartment',
                            'name' => 'house_apartment',
                              'value'=> $resource->house_apartment,

                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Floor',
                            'name' => 'floor',
                                                          'value'=> $resource->floor,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group" id="map">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <input id="CenterLocation" type="hidden" name="location" class="form-control"
                                   value="{{$resource->lat . ','. $resource->lng}}" placeholder="" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            $.ajax({
                type: "POST",
                url: "/gwc/get-country-cities-edit",
                data: {country_id: @json($resource->country_id), id: '{{$resource->city_id}}'},
                beforeSend: function () {
                    $("#city-list").addClass("loader");
                },
                success: function (data) {
                    $("#city-list").html(data);
                    $("#city-list").prop('disabled', false);
                    $("#city-list").removeClass("loader");
                    document.getElementById('city-list').value=@json($resource->city_id);
                    $.ajax({
                        type: "POST",
                        url: "/gwc/get-city-areas",
                        data: 'city_id=' + @json($resource->city_id),
                        beforeSend: function () {
                            $("#area-list").addClass("loader");
                        },
                        success: function (data) {
                            $("#area-list").html(data);
                            $("#area-list").prop('disabled', false);
                            $("#area-list").removeClass("loader");
                            document.getElementById('area-list').value=@json($resource->area_id);

                        }
                    });
                }
            });
        });

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
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <script>

        function getLatLong() {
            document.getElementById('map').innerHTML = "";
            document.getElementById('CenterLocation').value = null;

            var lat = '29.33761977879495'
            var long = '48.02477880141601'
            document.getElementById('map').innerHTML = ' <label>my map<span>*</span></label>   <div id="mapSender" style="height: 400px"></div>'
            var token = 'pk.eyJ1Ijoic29oZWlsdmFpbyIsImEiOiJja2kxcnUyYTUwNW03MnhudDNsOGRwNG94In0.h3EW-3gLt4EccaIq9tImIw';


            var sender = L.map('mapSender').setView([lat, long], 13);
            var markersender = L.marker([lat, long], {draggable: true}).addTo(sender);

            // markersender.bindPopup("<b>مرکز پردازش</b>").openPopup();


            markersender.on('dragend', function (e) {
                latdrag = markersender.getLatLng().lat;
                longdrag = markersender.getLatLng().lng;
                latlong = latdrag + ',' + longdrag;
                document.getElementById('CenterLocation').value = latlong;

            });

            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: token
            }).addTo(sender);
        }

        function defaultLatLng() {
            console.log('@json($resource->lng)')
            var lat = '{{$resource->lat}}'
            var long = '{{$resource->lng}}'
            document.getElementById('map').innerHTML = ' <label>my map<span>*</span></label>   <div id="mapSender" style="height: 400px"></div>'
            var token = 'pk.eyJ1Ijoic29oZWlsdmFpbyIsImEiOiJja2kxcnUyYTUwNW03MnhudDNsOGRwNG94In0.h3EW-3gLt4EccaIq9tImIw';

            var sender = L.map('mapSender').setView([lat, long], 13);
            var markersender = L.marker([lat, long], {draggable: true}).addTo(sender);

            // markersender.bindPopup("<b>مرکز پردازش</b>").openPopup();


            markersender.on('dragend', function (e) {
                latdrag = markersender.getLatLng().lat;
                longdrag = markersender.getLatLng().lng;
                latlong = latdrag + ',' + longdrag;
                document.getElementById('CenterLocation').value = latlong;

            });

            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: token
            }).addTo(sender);
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            if ('{{$resource->lat}}' && '{{$resource->lng}}') {
                defaultLatLng();
            } else {
                getLatLong();
            }

        })


    </script>
@endsection