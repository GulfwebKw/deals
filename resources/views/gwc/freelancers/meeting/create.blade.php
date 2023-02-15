@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{'/gwc/freelancer/'. Request::segment(3).'/meetings'}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <div class="form-group">
                <label class="">Select Date</label>

                <div class="row">
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group date">
                            <input type="text" class="form-control" readonly
                                   onchange="getSlot(this.value, '{{Request::segment(3)}}')"
                                   placeholder="Select date"
                                   id="kt_datepicker_2" name="date"/>
                            <div class="input-group-append">
														<span class="input-group-text">
															<i class="la la-calendar-check-o"></i>
														</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Slot</label>
                        <select name="slot" id="slot-list" class="form-control"
                                required>
                            <option value="">None</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Users</label>
                        <select name="user_id" id="user_id-list" class="form-control"
                                required>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->fullname}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @foreach($locations as $key=>$location)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="kt-radio kt-radio--bold kt-radio--success">
                                <input onchange="defaultLatLng()" data-key="{{$location}}" value="{{$location->id}}"
                                       type="radio" name="location" @if($key==0) checked @endif>
                                <h5>{{$location->full_name}}</h5>
                                <span></span>
                                <h6>{{$location->city}}</h6>
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group" id="map">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <input id="CenterLocation" type="hidden" name="location" class="form-control"
                                   value="{{$locations[0]->id}}" placeholder="" required>
                        </div>
                    </div>
                </div>
            </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection

@section('script')
    <script type="text/javascript"
            src="{{asset('admin_assets/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <script>
        function getSlot(val, freelancer) {
            $.ajax({
                type: "POST",
                url: "/gwc/freelancer/get-slot",
                data: {date: val, freelancer_id: freelancer},
                beforeSend: function () {
                    $("#slot-list").addClass("loader");
                },
                success: function (data) {
                    console.log(data)
                    $("#slot-list").html(data.slots);
                    $("#slot-list").prop('disabled', false);
                    $("#slot-list").removeClass("loader");
                }
            });
        }

        function getLatLong() {
            document.getElementById('map').innerHTML = "";
            document.getElementById('CenterLocation').value = null;

            var lat = '29.33761977879495'
            var long = '48.02477880141601'
            document.getElementById('map').innerHTML = ' <label>my map<span>*</span></label>   <div id="mapSender" style="height: 400px"></div>'
            var token = 'pk.eyJ1Ijoic29oZWlsdmFpbyIsImEiOiJja2kxcnUyYTUwNW03MnhudDNsOGRwNG94In0.h3EW-3gLt4EccaIq9tImIw';


            var sender = L.map('mapSender').setView([lat, long], 13);
            var markersender = L.marker([lat, long], {draggable: false}).addTo(sender);

            // markersender.bindPopup("<b>مرکز پردازش</b>").openPopup();

            //
            // markersender.on('dragend', function (e) {
            //     latdrag = markersender.getLatLng().lat;
            //     longdrag = markersender.getLatLng().lng;
            //     latlong = latdrag + ',' + longdrag;
            //     document.getElementById('CenterLocation').value = latlong;
            //
            // });

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
            var radios = document.getElementsByName('location');
            let location
            for (var i = 0, length = radios.length; i < length; i++) {
                if (radios[i].checked) {
                    // do whatever you want with the checked radio
                    location = radios[i].getAttribute('data-key')
                    location = JSON.parse(location)
                    // only one radio can be logically checked, don't check the rest
                    break;
                }
            }


            let latlng = document.getElementById('CenterLocation').value
            var lat = location.lat
            var long = location.lng
            console.log(lat, long)

            document.getElementById('map').innerHTML = ' <label>my map<span>*</span></label>   <div id="mapSender" style="height: 400px"></div>'
            var token = 'pk.eyJ1Ijoic29oZWlsdmFpbyIsImEiOiJja2kxcnUyYTUwNW03MnhudDNsOGRwNG94In0.h3EW-3gLt4EccaIq9tImIw';

            var sender = L.map('mapSender').setView([lat, long], 13);
            var markersender = L.marker([lat, long], {draggable: false}).addTo(sender);

            // markersender.bindPopup("<b>مرکز پردازش</b>").openPopup();


            // markersender.on('dragend', function (e) {
            //     latdrag = markersender.getLatLng().lat;
            //     longdrag = markersender.getLatLng().lng;
            //     latlong = latdrag + ',' + longdrag;
            //     document.getElementById('CenterLocation').value = latlong;
            //
            // });

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
            if ('{{$locations[0]->lat}}' && '{{$locations[0]->lng}}') {
                defaultLatLng();
            } else {
                getLatLong();
            }

        })


    </script>
@endsection