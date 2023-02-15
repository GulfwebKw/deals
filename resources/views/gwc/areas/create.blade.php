@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data" action="{{route($data['storeRoute'], Request::segment(2))}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- title -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Title (en)',
                            'name' => 'title_en',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Title (ar)',
                            'name' => 'title_ar',
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <!-- city -->
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <!-- is active? -->
                            <label class="col-3 col-form-label">{{__('adminMessage.isactive')}}</label>
                            <div class="col-3">
                                @component('gwc.components.createIsActive') @endcomponent
                            </div>
                        </div>
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
                            <input id="lat" type="hidden" name="lat" value="29.33761977879495">
                            <input id="lng" type="hidden" name="lng" value="48.02477880141601">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>

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



            markersender.on('dragend', function (e) {
                latdrag = markersender.getLatLng().lat;
                longdrag = markersender.getLatLng().lng;
                document.getElementById('lat').value = latdrag;
                document.getElementById('lng').value = longdrag;

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
            var lat = '29.33761977879495'
            var long = '48.02477880141601'
            document.getElementById('map').innerHTML = ' <label>my map<span>*</span></label>   <div id="mapSender" style="height: 400px"></div>'
            var token = 'pk.eyJ1Ijoic29oZWlsdmFpbyIsImEiOiJja2kxcnUyYTUwNW03MnhudDNsOGRwNG94In0.h3EW-3gLt4EccaIq9tImIw';

            var sender = L.map('mapSender').setView([lat, long], 13);
            var markersender = L.marker([lat, long], {draggable: true}).addTo(sender);



            markersender.on('dragend', function (e) {
                latdrag = markersender.getLatLng().lat;
                longdrag = markersender.getLatLng().lng;
                document.getElementById('lat').value = latdrag;
                document.getElementById('lng').value = longdrag;

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
            if ('29.33761977879495' && '48.02477880141601') {
                defaultLatLng();
            } else {
                getLatLong();
            }

        })


    </script>
@endsection