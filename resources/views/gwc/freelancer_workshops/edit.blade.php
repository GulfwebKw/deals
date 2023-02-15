@extends('gwc.template.editTemplate')
@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <style type="text/css">
        .dropzone {
            border: 2px dashed #999999;
            border-radius: 10px;
        }

        .dropzone .dz-default.dz-message {
            height: 171px;
            background-size: 132px 132px;
            margin-top: -101.5px;
            background-position-x: center;


        }

        .dropzone .dz-default.dz-message span {
            display: block;
            margin-top: 145px;
            font-size: 20px;
            text-align: center;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/basic.css" rel="stylesheet" type="text/css"/>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/basic.min.css" rel="stylesheet">
@endsection

@section('editContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{route($data['updateRoute'],[Request::segment(3),$resource->id])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="lastPage" value="{{ old('lastPage', url()->previous() ) }}">

        <div class="kt-portlet__body">
            <div>
                <div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @component('gwc.components.editTextInput', [
                                                'label' => 'Name Of Workshop ',
                                                'name' => 'name',
                                                'value'=>$resource->name ,
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @component('gwc.components.editTinyMce', [
                                                'label' => 'Description ',
                                                'name' => 'description',
                                                'value'=>$resource->description ,
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Date',
                            'name' => 'date',
                            'type' => 'date',
                            'value'=>$resource->date,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'From Time',
                            'name' => 'from_time',
                            'type' => 'time',
                            'value'=>$resource->from_time,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'To Time',
                            'name' => 'to_time',
                            'type' => 'time',
                            'value'=>$resource->to_time,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                        <div class="col-md-4">
                            @component('gwc.components.editTextInput', [
                                'label' => 'Price Per Person',
                                'name' => 'price',
                                'value'=>$resource->price,
                                'required' => true
                            ]) @endcomponent
                        </div>
                        <div class="col-md-4">
                            @component('gwc.components.editTextInput', [
                                'label' => 'Total Persons',
                                'name' => 'total_persons',
                                'value'=>$resource->total_persons,
                                'required' => true
                            ]) @endcomponent
                        </div>
                    <label class="col-2 col-form-label">{{__('adminMessage.isactive')}}</label>
                    <div class="col-2">
                        @component('gwc.components.editIsActive', [
                            'value' => $resource->is_active
                        ]) @endcomponent
                    </div>
                </div>
            </div>
            <!-- name -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label>Country</label>
                        <select onchange="getCities(this.value)" id="" class="form-control">
                            <option value="">None</option>
                            @foreach($countries as $country)
                                <option @if($country->id==$resource->country_id) selected @endif value="{{ $country->id }}">{{ $country->title_en }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>City</label>
                        <select id="city-list" onchange="getAreas(this.value)" class="form-control">
                            <option value="">None</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Area</label>
                        <select name="area_id" id="area-list" class="form-control">
                            <option value="{{$resource->area_id}}">not change</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Block',
                            'name' => 'block',
                            'value'=> $resource->block,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Street',
                            'name' => 'street',
                            'value'=> $resource->street,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'street',
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
                            'label' => 'building name',
                            'name' => 'building_name',
                             'value'=> $resource->building_name,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'apartment Nom',
                            'name' => 'apartment_no',
                             'value'=> $resource->apartment_no,
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
                    <div class="col-lg-6">
                        <!-- image -->
                        @php $label = "Image"; @endphp
                        @php $field = 'image'; @endphp
                        @component('gwc.components.createImageUpload', [
                            'label' => $label,
                            'name' => $field,
                        ]) @endcomponent
                    </div>
                    <div class="col-md-2">
                        <img src="{{$resource->images}}" alt="" width="100">
                    </div>
                </div>
            </div>
            
        </div>
        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent
    </form>
@stop
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script type="text/javascript">

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

        function DeletePic(name) {
            $.ajax({
                url: '{{ route('dropzone.image.delete') }}',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: 'POST',
                data: {name: name, id: '{{$resource->id}}', model: 'freelancer_workshops'},
                success: function (data) {
                    $('li[data-e="' + data + '"]').fadeOut();
                }
            });
        }


        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('dropzone.images.store') }}',
            maxFilesize: 1, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                var name = uploadedDocumentMap[file.name];
                var token = $('[name=_token]').val();
                var dir = $('[name=dir]').val();
                console.log(dir);


                $.ajax({
                    type: 'get',
                    headers: {'X-CSRF-Token': token},
                    url: '{{ route('dropzone.images.remove') }}',
                    data: {name: name, dir: dir},
                    dataType: 'html'
                });

                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                availableImages = availableImages + 1;
            },
            init: function () {
                @if(isset($project) && $project->document)
                var files =
                        {!! json_encode($project->document) !!}
                        for(
                var i
            in
                files
            )
                {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
                }
                @endif
            }
        };
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
            var lat ='{{$resource->lat}}'
            var long ='{{$resource->long}}'
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
            if ({{$resource->lat}} && {{$resource->long}}) {
                defaultLatLng();
            } else {
                getLatLong();
            }

        })


    </script>













@endsection