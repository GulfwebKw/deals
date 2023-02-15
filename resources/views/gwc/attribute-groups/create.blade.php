@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{route($data['storeRoute'])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- title -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Attribute Group Name',
                            'name' => 'name',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        <label>Attributes</label>
                        <select multiple name="attr[]" class="form-control"  required >
                            @foreach($resources as $attr)
                                <option value="{{ $attr->id }}">
                                    {{ json_decode($attr->value)->en }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent
    </form>
@endsection