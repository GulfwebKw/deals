@extends('gwc.template.editTemplate')

@section('editContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{route($data['updateRoute'],$resource->id)}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- type code value -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label>Coupon Type</label>
                        <span style="color: red">*</span>
                        <select name="coupon_type" class="form-control">
                            <option value="amount" @if($resource->coupon_type=='amount') selected @endif>KD</option>
                            <option value="percentage" @if($resource->coupon_type=='percentage') selected @endif>%</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Coupon Code',
                            'name' => 'coupon_code',
                            'value' => $resource->coupon_code,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Coupon Value',
                            'name' => 'coupon_value',
                            'value' => $resource->coupon_value,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <!-- title -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Title (en)',
                            'name' => 'title_en',
                            'value' => $resource->title_en,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Title (ar)',
                            'name' => 'title_ar',
                            'value' => $resource->title_ar,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <!-- date price -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Date Start',
                            'name' => 'date_start',
                            'type' => 'date',
                            'value' => $resource->date_start,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-3">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Date End',
                            'name' => 'date_end',
                            'type' => 'date',
                            'value' => $resource->date_end,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-3">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Price Start',
                            'name' => 'price_start',
                            'value' => $resource->price_start,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-3">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Price End',
                            'name' => 'price_end',
                            'value' => $resource->price_end,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <!-- usage limit & coupon for -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Coupon Is For</label>
                        <span style="color: red">*</span>
                        <select name="is_for" class="form-control">
                            <option value="web" @if($resource->is_for=='web') selected @endif>Web</option>
                            <option value="app" @if($resource->is_for=='app') selected @endif>App</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Usage Limit',
                            'name' => 'usage_limit',
                            'value' => $resource->usage_limit,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <!-- is free? -->
                            <label class="col-6 col-form-label">Is Free?</label>
                            <div class="col-6">
                                <span class="kt-switch">
                                    <label>
                                        <input type="checkbox" name="is_free" id="is_free" @if($resource->is_free) checked @endif />
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group row">
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
            </div>

        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection