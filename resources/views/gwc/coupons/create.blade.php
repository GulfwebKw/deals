@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data" action="{{route($data['storeRoute'])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- type code value -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label>Coupon Type</label>
                        <span style="color: red">*</span>
                        <select name="coupon_type" class="form-control">
                            <option value="amount">KD</option>
                            <option value="percentage">%</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Coupon Code',
                            'name' => 'coupon_code',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Coupon Value',
                            'name' => 'coupon_value',
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

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

            <!-- date price -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Date Start',
                            'name' => 'date_start',
                            'type' => 'date',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-3">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Date End',
                            'name' => 'date_end',
                            'type' => 'date',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-3">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Price Start',
                            'name' => 'price_start',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-3">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Price End',
                            'name' => 'price_end',
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
                            <option value="web">Web</option>
                            <option value="app">App</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Usage Limit',
                            'name' => 'usage_limit',
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
                            <label class="col-3 col-form-label">{{__('adminMessage.freeshipping')}}</label>
                            <div class="col-3">
                                <span class="kt-switch">
                                    <label>
                                        <input type="checkbox" name="is_free" id="is_free" checked value="1" />
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
                                @component('gwc.components.createIsActive') @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection