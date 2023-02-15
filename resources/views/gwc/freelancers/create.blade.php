@extends('gwc.template.createTemplate')

@section('createContent')
    <form name="tFrm" id="form_validation" method="post" class="kt-form" enctype="multipart/form-data"
          action="{{route($data['storeRoute'])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="kt-portlet__body">

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Name',
                            'name' => 'name',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Email',
                            'name' => 'email',
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Phone',
                            'name' => 'phone',
                            'required' => true
                        ]) @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('gwc.components.createTextInput', [
                            'label' => 'Link',
                            'name' => 'link',
                            'required' => true
                        ]) @endcomponent
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        @component('gwc.components.createTextarea', [
                                    'label'=> 'Bio',
                                    'name'=> 'bio'
                        ]) @endcomponent
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label>Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">None</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @if(count($category->childrenRecursive) > 0)
                                    @include('gwc.partials.category',['categories' => $category->childrenRecursive, 'level'=>0])
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <!-- image -->
                        @php $label = "Image"; @endphp
                        @php $field = 'image'; @endphp
                        @component('gwc.components.createImageUpload', [
                            'label' => $label,
                            'name' => $field,
                        ]) @endcomponent
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-auto col-form-label">{{__('adminMessage.isactive')}}</label>
                    <div class="col-auto">
                        @component('gwc.components.createIsActive') @endcomponent
                    </div>

                    <label class="col-auto col-form-label">{{__('adminMessage.quotation')}}</label>
                    <div class="col-auto">
                    <span class="kt-switch">
                         <label>
                             <input type="checkbox" checked="checked" name="quotation" id="is_active" value="1"/>
                              <span></span>
                         </label>
                    </span>
                    </div>

                    <label class="col-auto col-form-label">{{__('adminMessage.set_a_meeting')}}</label>
                    <div class="col-auto">
                    <span class="kt-switch">
                         <label>
                             <input type="checkbox" checked="checked" name="set_a_meeting" id="is_active" value="1"/>
                              <span></span>
                         </label>
                    </span>
                    </div>
                    <label class="col-auto col-form-label">{{__('adminMessage.offline')}}</label>
                    <div class="col-auto">
                    <span class="kt-switch">
                         <label>
                             <input type="checkbox" checked="checked" name="offline" id="is_active" value="1"/>
                              <span></span>
                         </label>
                    </span>
                    </div>
                </div>
            </div>

        </div>
        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent
    </form>
@endsection