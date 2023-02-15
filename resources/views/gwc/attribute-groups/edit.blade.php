@extends('gwc.template.editTemplate')

@section('editContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{route($data['updateRoute'],$resource->id)}}">
        @method('PUT')
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <!-- title -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Attribute Group Name',
                            'name' => 'name',
                            'value' => $resource->name,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                            <label>Attributes</label>
                            <select multiple  name="attr[]" class="form-control" required>
                                @foreach($attributes as $res)
                                    <option value="{{ $res->value, true }}" @if(in_array(json_decode($res->value)->en, $value)) selected @endif >
                                        {{json_decode($res->value)->en }}
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