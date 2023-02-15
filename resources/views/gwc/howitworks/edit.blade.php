@extends('gwc.template.editTemplate')

@section('editContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{route($data['updateRoute'],$resource->id)}}">
        @method('PUT')
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">
            <div class="">
                <div class="">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line">
                        @foreach($langs as $key=>$lang)
                            <li class="nav-item">
                                <a class="nav-link {{$key==0?'active':''}}" data-toggle="tab"
                                   href="{{'#'. $lang->key}}">{{$lang->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="card-body">
                        <div class="tab-content">
                            @foreach($langs as $key=>$lang)
                                <div class="tab-pane fade {{$key==0?'show active':''}}" id="{{$lang->key}}"
                                     role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @component('gwc.components.editTextInput', [
                                                    'label' => 'Title ( '. $lang->key . ' )',
                                                    'name' => 'title_' . $lang->key,
                                                    'value'=>$resource->translate($lang->key)?$resource->translate($lang->key)->title:'',
                                                    'required' => true
                                                ]) @endcomponent
                                            </div>
                                            <div class="col-md-6">
                                                @component('gwc.components.editTextInput', [
                                                    'label' => 'Sub Title ( '. $lang->key . ' )',
                                                    'name' => 'sub_title_' . $lang->key,
                                                    'value'=>$resource->translate($lang->key)?$resource->translate($lang->key)->sub_title:'',
                                                    'required' => true
                                                ]) @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                @component('gwc.components.editTextarea', [
                                                            'label'=> 'description ( '. $lang->key . ' )',
                                                            'value'=>$resource->translate($lang->key)?$resource->translate($lang->key)->description:'',
                                                            'name'=> 'meta_desc_'. $lang->key
                                                ]) @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <!-- title -->
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-5">
                        <!-- image -->
                        @php $label = "Image"; @endphp
                        @php $field = 'image'; @endphp
                        @component('gwc.components.createImageUpload', [
                            'label' => $label,
                            'name' => $field,
                        ]) @endcomponent
                    </div>
                    <div class="col-md-2">
                        <img src="{{'/uploads/howitworks/thumb/'.$resource->image}}" alt="">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <!-- display order -->
                    <label class="col-auto col-form-label">{{__('adminMessage.displaynumber')}}</label>
                    <div class="col-auto">
                            <input
                                    type="number"
                                    class="form-control @if($errors->has('display_number')) is-invalid @endif"
                                    name="display_number"
                                    value="{{old('display_number') ? old('display_number') : $resource->display_number }}"
                                    autocomplete="off"
                                    min="0"
                                    required
                            />
                            @if($errors->has('display_number'))
                                <div class="invalid-feedback">{{ $errors->first('display_number') }}</div>
                            @endif
                    </div>
                    <!-- display order -->
                    <label class="col-auto col-form-label">{{__('adminMessage.step')}}</label>
                    <div class="col-auto">
                        <input
                                type="number"
                                class="form-control @if($errors->has('step')) is-invalid @endif"
                                name="step"
                                value="{{old('step') ? old('step') : $resource->step }}"
                                autocomplete="off"
                                min="0"
                                required
                        />
                        @if($errors->has('step'))
                            <div class="invalid-feedback">{{ $errors->first('step') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection