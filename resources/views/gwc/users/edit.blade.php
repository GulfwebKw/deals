@extends('gwc.template.editTemplate')

@section('editContent')
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar">
            <ul class="nav nav-tabs  nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if(Request::segment(4)=='edit') active @endif" href="{{url('gwc/users/'.$id.'/edit')}}" role="tab">
                        <i class="flaticon-avatar"></i> {{__('adminMessage.profile')}}
                    </a>
                </li>
                @if(auth()->guard('admin')->user()->can('users-changepass'))
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(3)=='changepass') active @endif" href="{{url('gwc/users/changepass/'.$id)}}" role="tab">
                            <i class="flaticon-lock"></i> {{__('adminMessage.changepassword')}}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="tab-content">

            <!-- edit tab -->
            <div class="tab-pane @if(Request::segment(4)=='edit') active @endif" id="edit">
                <div class="kt-form kt-form--label-right">
                    @if(auth()->guard('admin')->user()->can($data['editPermission']))
                        <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
                              action="{{route($data['updateRoute'],$resource->id)}}">
                            @method('PUT')
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="kt-portlet__body">

                                <!-- avatar -->
                                <div class="form-group">
                                    <div class="row text-center">
                                        <div class="col-12 mx-auto">
                                            <div class="kt-avatar kt-avatar--outline kt-avatar--circle- @if($errors->has('image')) is-invalid @endif" id="kt_user_edit_avatar">
                                                @if(isset($resource->image) && !empty($resource->image))
                                                    <div class="kt-avatar__holder" style="background-image: url('{!! asset($resource->image) !!}');"></div>
                                                @else
                                                    <div class="kt-avatar__holder" style="background-image: url('{!! asset('admin_assets/assets/media/users/default.jpg') !!}');"></div>
                                                @endif
                                                <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
                                                    <i class="fa fa-pen"></i>
                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg">
                                                </label>
                                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
                                                <i class="fa fa-times"></i>
                                            </span>
                                            </div>
                                            @if($errors->has('image'))
                                                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- name -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @component('gwc.components.editTextInput', [
                                                'label' => 'First Name',
                                                'name' => 'first_name',
                                                'value' => $resource->first_name,
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('gwc.components.editTextInput', [
                                                'label' => 'Last Name',
                                                'name' => 'last_name',
                                                'value' => $resource->last_name,
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <!-- email -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @component('gwc.components.editTextInput', [
                                                'label' => 'Email',
                                                'name' => 'email',
                                                'value' => $resource->email,
                                                'type' => 'email',
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('gwc.components.editTextInput', [
                                                'label' => 'Mobile',
                                                'name' => 'mobile',
                                                'value' => $resource->mobile,
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <!-- gender birthday -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">

                                            @component('gwc.components.editTextInput', [
                                                'label' => 'Birthday',
                                                'name' => 'birthday',
                                                'type'=>'date',
                                                'value' => $resource->birthday,
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control" required>
                                                <option value="male" @if($resource->gender == 'male') selected @endif>Male</option>
                                                <option value="female" @if($resource->gender == 'female') selected @endif>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
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

                                <!-- country city area -->
{{--                                <div class="form-group">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            <label>Country</label>--}}
{{--                                            <span style="color: red">*</span>--}}
{{--                                            <select name="country" id="country-list" class="form-control" onChange="getCities(this.value);" required>--}}
{{--                                                <option value="" disabled selected>Select Country</option>--}}
{{--                                                @foreach($countries as $country)--}}
{{--                                                    <option value="{{$country->id}}" @if($resource->country_id == $country->id) selected @endif>--}}
{{--                                                        {{$country->title_en}}--}}
{{--                                                    </option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            <label>City</label>--}}
{{--                                            <span style="color: red">*</span>--}}
{{--                                            <select name="city" id="city-list" class="form-control" onChange="getAreas(this.value);" required>--}}
{{--                                                <option value="" disabled selected>Select City</option>--}}
{{--                                                @foreach($cities as $city)--}}
{{--                                                    <option value="{{$city->id}}" @if($resource->city_id == $city->id) selected @endif>--}}
{{--                                                        {{$city->title_en}}--}}
{{--                                                    </option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            <label>Area</label>--}}
{{--                                            <span style="color: red">*</span>--}}
{{--                                            <select name="area" id="area-list" class="form-control" required>--}}
{{--                                                <option value="" disabled selected>Select Area</option>--}}
{{--                                                @foreach($areas as $area)--}}
{{--                                                    <option value="{{$area->id}}" @if($resource->area_id == $area->id) selected @endif>--}}
{{--                                                        {{$area->title_en}}--}}
{{--                                                    </option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <!-- address -->
{{--                                <div class="form-group">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            @component('gwc.components.editTextInput', [--}}
{{--                                                'label' => 'Block',--}}
{{--                                                'name' => 'block',--}}
{{--                                                'value' => $resource->block,--}}
{{--                                                'required' => true--}}
{{--                                            ]) @endcomponent--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            @component('gwc.components.editTextInput', [--}}
{{--                                                'label' => 'Street',--}}
{{--                                                'name' => 'street',--}}
{{--                                                'value' => $resource->street,--}}
{{--                                                'required' => true--}}
{{--                                            ]) @endcomponent--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            @component('gwc.components.editTextInput', [--}}
{{--                                                'label' => 'Avenue',--}}
{{--                                                'name' => 'avenue',--}}
{{--                                                'value' => $resource->avenue,--}}
{{--                                                'required' => true--}}
{{--                                            ]) @endcomponent--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <!-- address -->
{{--                                <div class="form-group">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            @component('gwc.components.editTextInput', [--}}
{{--                                                'label' => 'House No',--}}
{{--                                                'name' => 'house_no',--}}
{{--                                                'value' => $resource->house_no,--}}
{{--                                                'required' => true--}}
{{--                                            ]) @endcomponent--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            @component('gwc.components.editTextInput', [--}}
{{--                                                'label' => 'Flat',--}}
{{--                                                'name' => 'flat',--}}
{{--                                                'value' => $resource->flat,--}}
{{--                                                'required' => true--}}
{{--                                            ]) @endcomponent--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                            </div>

                            @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

                        </form>
                    @endif
                </div>
            </div>
            <!-- end edit tab -->

            <!-- change pass tab -->
            @if(auth()->guard('admin')->user()->can('admins-changepass'))
                <div class="tab-pane @if(Request::segment(3)=='changepass') active @endif" id="changepass">
                    <div class="kt-form kt-form--label-right">
                        <form name="tFrmpass" id="tFrmpass" method="post" class="uk-form-stacked" enctype="multipart/form-data" action="{{route('userChangePass',$resource->id)}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">

                                        <!-- current password -->
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @component('gwc.components.editTextInput', [
                                                        'label' => 'Current Password',
                                                        'name' => 'current_password',
                                                        'value' => "",
                                                        'type' => 'password',
                                                        'required' => true
                                                    ]) @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <!-- new password -->
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @component('gwc.components.editTextInput', [
                                                        'label' => 'New Password',
                                                        'name' => 'new_password',
                                                        'value' => "",
                                                        'type' => 'password',
                                                        'required' => true
                                                    ]) @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <!-- confirm password -->
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @component('gwc.components.editTextInput', [
                                                        'label' => 'Confirm Password',
                                                        'name' => 'confirm_password',
                                                        'value' => "",
                                                        'type' => 'password',
                                                        'required' => true
                                                    ]) @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

                        </form>

                    </div>
                </div>
        @endif
        <!-- end change pass tab -->

        </div>
    </div>

@endsection