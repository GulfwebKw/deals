@extends('gwc.template.editTemplate')

@section('editContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{$resource->id > 0 ? route($data['updateRoute'],$resource->id) : route($data['storeRoute'])}}">
        @if($resource->id) @method('PUT') @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Code</label> <span style="color: red">*</span>
                        <input type="text" class="form-control @if($errors->has('code')) is-invalid @endif"
                               name="code" required id="codeInput"
                               placeholder="Please enter code"
                               value="{{ old('code' , $resource->code) }}">
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <button id="retrieveButton"
                                type="button"
                                class="btn btn-outline-info"
                                style="margin-top: 26px;"
                        >Generate New Code</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Count (leave empty for unlimited.)</label>
                        <input type="number" class="form-control @if($errors->has('count')) is-invalid @endif"
                               name="count"
                               placeholder="Please enter count"
                               value="{{ intval(old('count' , $resource->count)) >= 0 ? intval(old('count' , $resource->count)) : '' }}">
                        @if($errors->has('count'))
                            <div class="invalid-feedback">
                                {{ $errors->first('count') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <!-- is active? -->
                        <label class="col-3 col-form-label">{{__('adminMessage.isactive')}}</label>
                        <div class="col-3">
                            @component('gwc.components.editIsActive', [
                                'value' => $resource->is_active
                            ]) @endcomponent
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <label>Discount Type</label>
                        <select id="type" class="form-control">
                            <option value="price_div" @if($resource->price > 0 or $resource->percent == 0 ) selected @endif>Price</option>
                            <option value="percent_div" @if($resource->percent > 0 ) selected @endif>Percent</option>
                        </select>
                    </div>
                    <div class="col-lg-6 shouldHide" id="price_div" @if( ! ($resource->price > 0 or $resource->percent == 0 )) style="display: none;" @endif>
                        <label>Price</label> <span style="color: red">*</span>
                        <input type="number" class="form-control @if($errors->has('price')) is-invalid @endif"
                               name="price" id="price" min="0" max="100"
                               placeholder="Please enter price"
                               value="{{ old('price' , $resource->price) > 0 ? old('price' , $resource->price) : '' }}">
                        @if($errors->has('price'))
                            <div class="invalid-feedback">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 shouldHide" id="percent_div" @if( ! $resource->percent > 0 ) style="display: none;" @endif>
                        <label>Percent</label> <span style="color: red">*</span>
                        <input type="number" class="form-control @if($errors->has('percent')) is-invalid @endif"
                               name="percent" id="percent" min="0" max="100"
                               placeholder="Please enter percent"
                               value="{{ old('percent' , $resource->percent) > 0 ? old('percent' , $resource->percent) : '' }}">
                        @if($errors->has('percent'))
                            <div class="invalid-feedback">
                                {{ $errors->first('percent') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>From (leave empty for unlimited.)</label>
                        <input type="date" class="form-control @if($errors->has('valid_from')) is-invalid @endif"
                               name="valid_from"
                               placeholder="Please enter from date"
                               value="{{ old('valid_from' , optional($resource->valid_from)->format('Y-m-d')) }}">
                        @if($errors->has('valid_from'))
                            <div class="invalid-feedback">
                                {{ $errors->first('valid_from') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label>to (leave empty for unlimited.)</label>
                        <input type="date" class="form-control @if($errors->has('valid_to')) is-invalid @endif"
                               name="valid_to"
                               placeholder="Please enter to date"
                               value="{{ old('valid_to' , optional($resource->valid_to)->format('Y-m-d')) }}">
                        @if($errors->has('valid_to'))
                            <div class="invalid-feedback">
                                {{ $errors->first('valid_to') }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#retrieveButton').click(function() {
                $.ajax({
                    url: '{{ $data['url'].'get/code' }}',
                    method: 'GET',
                    success: function(response) {
                        $('#codeInput').val(response);
                    },
                    error: function() {
                        console.log('Error retrieving code from server.');
                    }
                });
            });
            $('#type').change(function() {
                var selectedOption = $(this).val();
                $('.shouldHide').hide();
                $('#' + selectedOption).show();
                if ( selectedOption === "price_div")
                    $('#percent').val('');
                if ( selectedOption === "percent_div")
                    $('#price').val('');
            });
        });
    </script>
@endsection