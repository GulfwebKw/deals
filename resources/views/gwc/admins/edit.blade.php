@extends('gwc.template.editTemplate')

@section('editContent')
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar">
            <ul class="nav nav-tabs  nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if(Request::segment(4)=='edit') active @endif" href="{{url('gwc/admins/'.$id.'/edit')}}" role="tab">
                        <i class="flaticon-avatar"></i> {{__('adminMessage.profile')}}
                    </a>
                </li>
                @if(auth()->guard('admin')->user()->can('admins-changepass'))
                <li class="nav-item">
                    <a class="nav-link @if(Request::segment(3)=='changepass') active @endif" href="{{url('gwc/admins/changepass/'.$id)}}" role="tab">
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
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="kt-portlet__body">

                                <!-- avatar -->
                                <div class="form-group">
                                    <div class="row text-center">
                                        <div class="col-12 mx-auto">
                                            <div class="kt-avatar kt-avatar--outline kt-avatar--circle- @if($errors->has('image')) is-invalid @endif" id="kt_user_edit_avatar">
                                                @if(isset($resource->image) && !empty($resource->image))
                                                    <div class="kt-avatar__holder" style="background-image: url('{!! asset('/uploads/admins/'.$resource->image) !!}');"></div>
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
                                        <div class="col-md-4">
                                            @component('gwc.components.editTextInput', [
                                                'label' => 'Name',
                                                'name' => 'name',
                                                'value' => $resource->name,
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            @component('gwc.components.editTextInput', [
                                                'label' => 'Email',
                                                'name' => 'email',
                                                'value' => $resource->email,
                                                'type' => 'email',
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                        <div class="col-md-4">
                                            @component('gwc.components.editTextInput', [
                                                'label' => 'Mobile',
                                                'name' => 'mobile',
                                                'value' => $resource->mobile,
                                                'required' => true
                                            ]) @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <!-- roles -->
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="">{{__('adminMessage.roles')}}</label>
                                        <select name="roles[]" class="form-control" multiple @if($errors->has('roles')) is-invalid @endif>
                                            @foreach($roles as $role)
                                                <option value="{{$role}}" {{in_array($role, $userRoles) ? 'selected' : ''}}>
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('roles'))
                                            <div class="invalid-feedback">{{ $errors->first('roles') }}</div>
                                        @endif
                                    </div>
                                </div>

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
                        <form name="tFrmpass" id="tFrmpass" method="post" class="uk-form-stacked" enctype="multipart/form-data" action="{{route('adminChangePass',$resource->id)}}">
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