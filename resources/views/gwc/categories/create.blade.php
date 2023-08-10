@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{route($data['storeRoute'])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">
            <div class="">
                <div class="">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line">
                        @foreach($langs as $key=>$lang)
                            <li class="nav-item">
                                <a class="nav-link {{$key==0?'active':''}}" data-toggle="tab" href="{{'#'. $lang->key}}">{{$lang->name}}</a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="card-body">
                        <div class="tab-content">
                            @foreach($langs as $key=>$lang)
                                <div class="tab-pane fade {{$key==0?'show active':''}}" id="{{$lang->key}}" role="tabpanel" aria-labelledby="kt_tab_pane_2">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @component('gwc.components.createTextInput', [
                                                    'label' => 'Title ( '. $lang->key . ' )',
                                                    'name' => 'title_' . $lang->key,
                                                    'required' => true
                                                ]) @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                @component('gwc.components.createTextarea', [
                                                            'label'=> 'description ( '. $lang->key . ' )',
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
            <!-- title -->

            <div class="form-group">
                <div class="row">
                    <div class="col-auto">
                        <div class="form-group row">
                            <!-- is active? -->
                            <div class="col-md-4">
                                <label>{{__('adminMessage.isactive')}}</label>
                                <div>
                                    @component('gwc.components.createIsActive') @endcomponent
                                </div>
                            </div>
                            <!-- display order -->
                            <div class="col-md-4">
                                <label>{{__('adminMessage.displayorder')}}</label>
                                @component('gwc.components.createDisplayOrder', [
                                    'lastOrder' => $lastOrder
                                ]) @endcomponent
                            </div>
                            <div class="col-md-4">
                                <label>parent</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach($resources as $resource)
                                        <option value="{{ $resource->id }}">{{ $resource->title }}</option>
                                        @if(count($resource->childrenRecursive) > 0)
                                            @include('gwc.partials.category',['categories' => $resource->childrenRecursive, 'level'=>0])
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                        ]) @endcomponent
                    </div>
                    <div class="col-lg-6">
                        <!-- image -->
                        @php $label = "Second Image"; @endphp
                        @php $field = 'second_image'; @endphp
                        @component('gwc.components.createImageUpload', [
                            'label' => $label,
                            'name' => $field,
                        ]) @endcomponent
                    </div>
                </div>
            </div>
        </div>
        </div>
        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent
    </form>
@endsection