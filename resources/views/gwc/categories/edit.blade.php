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
                                            <div class="col-md-12">
                                                @component('gwc.components.editTextInput', [
                                                    'label' => 'Title ( '. $lang->key . ' )',
                                                    'name' => 'title_' . $lang->key,
                                                    'value'=>$resource->translate($lang->key)?$resource->translate($lang->key)->title:'',
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
                                                            'value'=>$resource->translate($lang->key)?$resource->translate($lang->key)->meta_desc:'',
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
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group row">
                            <!-- is active? -->
                            <label class="col-3 col-form-label">{{__('adminMessage.isactive')}}</label>
                            <div class="col-3">
                                @component('gwc.components.editIsActive', [
									'value' => $resource->is_active
								]) @endcomponent
                            </div>
                            <!-- display order -->
                            <label class="col-3 col-form-label">{{__('adminMessage.displayorder')}}</label>
                            <div class="col-3">
                                @component('gwc.components.editDisplayOrder', [
                                    'lastOrder' => $resource->display_order
                                ]) @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- title -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5">
                            <label>parent</label>
                            <select name="parent_id" class="form-control">
                                    <option value="">None</option>
                                @foreach($categories as $category)
                                    <option @if(in_array($category->id, $childrenIds->toArray())) disabled @endif  value="{{ $category->id }}" @if($category->id == $resource->parent_id) selected @endif>
                                        {{ $category->title }}
                                    </option>
                                @if(count($category->childrenRecursive)>0)
                                        @include('gwc.partials.Editcategory',['categories' => $category->childrenRecursive, 'parent_id'=>$resource->parent_id, 'notSelectable'=>$childrenIds, 'level'=>0,'category_id'=>$resource->category_id])
                                    @endif
                                @endforeach
                            </select>
                    </div>
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
                        <img src="{{$resource->image}}" alt="" style="max-width:100%">
                    </div>
                </div>
            </div>
        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection