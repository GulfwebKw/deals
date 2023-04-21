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
                            'name' => 'question_en',
                            'value'=>$resource->question_en,
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.editTextInput', [
                            'label' => 'Title (ar)',
                            'name' => 'question_ar',
                            'value'=>$resource->question_ar,
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

           


            <!-- Details -->
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.editTinyMce', [
                           'label' => 'description (en)',
                           'name' => 'answer_en',
                           'value' => $resource->answer_en,
                           'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.editTinyMce', [
                           'label' => 'description (ar)',
                           'name' => 'answer_ar',
                           'value' => $resource->answer_ar,
                           'required' => true
                        ]) @endcomponent
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
                            <div class="col-3">
                                <label>Active For</label>
                                <select name="active_for" class="form-control" required >
                                    <option value="Both" @if( $resource->active_for == "Both" ) selected @endif>Both</option>
                                    <option value="User" @if( $resource->active_for == "User" ) selected @endif>User</option>
                                    <option value="Freelancer" @if( $resource->active_for == "Freelancer" ) selected @endif>Freelancer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection