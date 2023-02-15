@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data" action="{{route($data['storeRoute'])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- name -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Name',
                            'name' => 'name',
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <hr>

            <!-- permissions -->
            <div class="form-group row">
                <h4>Permissions</h4>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <div class="kt-checkbox-list kt-checkbox-inline">
                        @foreach($groups as $group)
                            <fieldset>
                                <legend>{{ $group['name'] }}</legend>
                                <div class="row">
                                    @foreach($group['permissions'] as $permission)
                                        <div class="col-lg-3">
                                            <label class="kt-checkbox" for="per-{{$permission->id}}">
                                                <input type="checkbox" name="permissions[]" id="per-{{$permission->id}}" value="{{$permission->id}}">
                                                {{ $permission->name }}
                                                <span></span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection