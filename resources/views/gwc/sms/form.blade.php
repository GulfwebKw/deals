@extends('gwc.template.formTemplate')

@section('formContent')
    <form name="tFrm" id="form_validation" method="post" action="{{route($data['updateRoute'])}}" class="kt-form" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{__('adminMessage.storedetails')}}
                            </h3>
                        </div>
                    </div>

                    <!-- begin portlet body -->
                    <div class="kt-portlet__body">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <!-- user id -->
                                    @component('gwc.components.editTextInput', [
                                        'label' => 'User ID',
                                        'name' => 'user_id',
                                        'value' => $resource->user_id,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-3">
                                    <!-- sender name -->
                                    @component('gwc.components.editTextInput', [
                                        'label' => 'Sender Name',
                                        'name' => 'sender_name',
                                        'value' => $resource->sender_name,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-4">
                                    <!-- api key -->
                                    @component('gwc.components.editTextInput', [
                                        'label' => 'API Key',
                                        'name' => 'api_key',
                                        'value' => $resource->api_key,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <!-- is active? -->
                                        <label class="col-6 col-form-label">{{__('adminMessage.isactive')}}</label>
                                        <div class="col-6">
                                            @component('gwc.components.editIsActive', [
                                                'value' => $resource->is_active
                                            ]) @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6> NOTE: The above information you have to get from dezsms.com like USERID , SENDER NAME , API KEY , API URL </h6>
                        <br><br><hr><br>

                        <!-- SMS Notification on order placed(COD) -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    @component('gwc.components.editTextarea', [
                                        'label' => 'SMS Notification on order placed(COD) (en)',
                                        'name' => 'cod_en',
                                        'value' => $resource->cod_en,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-5">
                                    @component('gwc.components.editTextarea', [
                                        'label' => 'SMS Notification on order placed(COD) (ar)',
                                        'name' => 'cod_ar',
                                        'value' => $resource->cod_ar,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <!-- is active? -->
                                        <label class="col-6 col-form-label">{{__('adminMessage.isactive')}}</label>
                                        <div class="col-6">
                                            <span class="kt-switch">
                                                <label>
                                                    <input type="checkbox" name="cod_active" id="cod_active" @if($resource->cod_active) checked @endif />
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SMS Notification on order placed(KNET) -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    @component('gwc.components.editTextarea', [
                                        'label' => 'SMS Notification on order placed(KNET) (en)',
                                        'name' => 'knet_en',
                                        'value' => $resource->knet_en,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-5">
                                    @component('gwc.components.editTextarea', [
                                        'label' => 'SMS Notification on order placed(KNET) (ar)',
                                        'name' => 'knet_ar',
                                        'value' => $resource->knet_ar,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <!-- is active? -->
                                        <label class="col-6 col-form-label">{{__('adminMessage.isactive')}}</label>
                                        <div class="col-6">
                                            <span class="kt-switch">
                                                <label>
                                                    <input type="checkbox" name="knet_active" id="knet_active" @if($resource->knet_active) checked @endif />
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SMS Notification on order track history -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    @component('gwc.components.editTextarea', [
                                        'label' => 'SMS Notification on order track history (en)',
                                        'name' => 'track_order_en',
                                        'value' => $resource->track_order_en,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-5">
                                    @component('gwc.components.editTextarea', [
                                        'label' => 'SMS Notification on order track history (ar)',
                                        'name' => 'track_order_ar',
                                        'value' => $resource->track_order_ar,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <!-- is active? -->
                                        <label class="col-6 col-form-label">{{__('adminMessage.isactive')}}</label>
                                        <div class="col-6">
                                            <span class="kt-switch">
                                                <label>
                                                    <input type="checkbox" name="track_order_active" id="track_order_active" @if($resource->track_order_active) checked @endif />
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SMS Notification on out of stock -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    @component('gwc.components.editTextarea', [
                                        'label' => 'SMS Notification on out of stock (en)',
                                        'name' => 'outofstock_en',
                                        'value' => $resource->outofstock_en,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-5">
                                    @component('gwc.components.editTextarea', [
                                        'label' => 'SMS Notification on out of stock (ar)',
                                        'name' => 'outofstock_ar',
                                        'value' => $resource->outofstock_ar,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <!-- is active? -->
                                        <label class="col-6 col-form-label">{{__('adminMessage.isactive')}}</label>
                                        <div class="col-6">
                                            <span class="kt-switch">
                                                <label>
                                                    <input type="checkbox" name="outofstock_active" id="outofstock_active" @if($resource->outofstock_active) checked @endif />
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    @component('gwc.templateIncludes.formFooter') @endcomponent

                </div>
            </div>
        </div>
    </form>
@endsection