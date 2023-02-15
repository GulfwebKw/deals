@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{'/gwc/users/'. Request::segment(3).'/address'}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <div class="form-group">
                <label class="">Select Date</label>

                <div class="row">
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <div class="input-group date">
                            <input type="text" class="form-control" readonly onchange="getSlot(this.value)"
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
            <!-- email -->
            <div class="form-group">
                <div class="row">

                    <div class="col-md-6">
                        <label>Slot</label>
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
        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
    <script>
        function getSlot(val) {
            console.log(val)
            $.ajax({
                type: "POST",
                url: "/gwc/get-slot",
                data: {date: val, },
                beforeSend: function () {
                    $("#city-list").addClass("loader");
                },
                success: function (data) {
                    console.log(data)
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
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('admin_assets/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>

@endsection