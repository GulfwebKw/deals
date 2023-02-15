@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{route($data['storeRoute'], Request::segment(3))}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 offset-2">
                        <example></example>

                        <div class="form-group row">
                            <div class="input-daterange input-group" id="kt_datepicker_5">
                                <label class="col-form-label col-lg-3 col-sm-12">Range Picker</label>
                                <input type="text" class="form-control" name="start"/>
                                <div class="input-group-append">
                                                    <span class="input-group-text"><i
                                                                class="la la-ellipsis-h"></i></span>
                                </div>
                                <input type="text" class="form-control" name="end"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 offset-2">
                        <div class="form-group row">
                            <label class="col-form-label">Input Group Setup</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="input-group date">
                                    <input type="text" class="form-control" readonly
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
                </div>
            </div>

     <button class="btn btn-primary" type="button" onclick="counter()">add</button>
            <div id="add">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Start Time</label>
                            <div class="input-group timepicker">
                                <div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-clock-o"></i>
														</span>
                                </div>
                                <input name="start" class="form-control" id="kt_timepicker_3" readonly
                                       placeholder="Select time" type="text"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">End Time</label>
                            <div class="input-group timepicker">
                                <div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-clock-o"></i>
														</span>
                                </div>
                                <input name="start" class="form-control" id="kt_timepicker_3" readonly
                                       placeholder="Select time" type="text"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @component('gwc.components.createTextInput', [
                                'label' => 'Buffer',
                                'name' => 'buffer',
                            ]) @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent
    </form>
@stop
@section('script')

<script>
    function counter(){
{{--        var htmll = ""--}}
{{--         htmll = '<script src="admin_assets/assets/js/pages/crud/forms/widgets/bootstrap-timepicker.js" type="text/javascript">'--}}
{{--        htmll = '</' + 'script>';--}}

{{--        var html = "";--}}
{{--        html += '<div class="form-group"><div class="row"><div class="col-md-4"><label for="">Start Time</label><div class="input-group timepicker"><div class="input-group-prepend"><span class="input-group-text"> <i class="la la-clock-o"></i></span></div><input name="start" class="form-control" id="" readonly placeholder="Select time" type="text"/></div></div><div class="col-md-4"><label for="">End Time</label><div class="input-group timepicker"><div class="input-group-prepend"><span class="input-group-text"><i class="la la-clock-o"></i></span></div><input name="start" class="form-control kt_timepicker_3" id="" readonly placeholder="Select time" type="text"/></div></div>'--}}
{{--        html +='<div class="col-md-4"><label>Buffer</label><input  type="text" class="form-control" name="buffer" placeholder="Please enter Buffer"></div></div>';--}}

{{--        $( "#add" ).append( htmll );--}}
{{--        $( "#add" ).append( html );--}}
    }
</script>
@endsection