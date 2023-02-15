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
                            'label' => 'Tilte (en)',
                            'name' => 'title_en',
                            'value'=>$resource->title_en,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Title (ar)',
                            'name' => 'title_ar',
                            'value'=>$resource->title_ar,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <!-- link -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Link or ID',
                            'name' => 'link_or_id',
                            'value'=>$resource->link_or_id
                        ]) @endcomponent
                    </div>
                </div>
            </div>


            <!-- Details -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.editSelectBox', [
                            'label' => 'Type',
                            'name' => 'type',
                            'resources' => $type,
                            'foreign_key' => $resource->type,
                            'title' => 'title',
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
                            'value'=>$resource->image,
                        ]) @endcomponent
                    </div>
                    <div class="col-md-2">
                        <img src="{{$resource->image}}" alt="" width="60">
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <!-- is active? -->
                            <label class="col-3 col-form-label">{{__('adminMessage.isactive')}}</label>
                            <div class="col-3">
                                @component('gwc.components.editIsActive',[
                                 'value'=>$resource->is_active
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


        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection