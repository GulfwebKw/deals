@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data" action="{{route($data['storeRoute'])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- name -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Name',
                            'name' => 'name',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Email',
                            'name' => 'email',
                            'type' => 'email',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-4">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Mobile',
                            'name' => 'mobile',
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <!-- auth -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Username',
                            'name' => 'username',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Password',
                            'name' => 'password',
                            'type' => 'password',
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
                            'required' => true
                        ]) @endcomponent
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

            <!-- roles -->
            <div class="form-group row">
                <div class="col-12">
                    <label>{{__('adminMessage.roles')}}</label>
                    <select name="roles[]" class="form-control" multiple @if($errors->has('roles')) is-invalid @endif required>
                        @foreach($roles as $role)
                            <option value="{{$role}}">
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
@endsection