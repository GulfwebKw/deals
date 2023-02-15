@extends('gwc.template.formTemplate')

@section('formContent')
    <form name="tFrm" id="form_validation" method="post" action="{{route($data['updateRoute'])}}" class="kt-form" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{__('adminMessage.storedetails')}}
                            </h3>
                        </div>
                    </div>

                    <!-- begin portlet body -->
                    <div class="kt-portlet__body">

                        <!-- about us details -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    @component('gwc.components.editTinyMce', [
                                        'label' => 'Details (en)',
                                        'name' => 'details_en',
                                        'value' => $resource->details_en,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                                <div class="col-md-6">
                                    @component('gwc.components.editTinyMce', [
                                        'label' => 'Details (ar)',
                                        'name' => 'details_ar',
                                        'value' => $resource->details_ar,
                                        'required' => true
                                    ]) @endcomponent
                                </div>
                            </div>
                        </div>

                        <!-- image -->
                        <div class="form-group">
                            <div class="row">
                                @php $label = "Image"; @endphp
                                @php $field = 'image'; @endphp
                                @component('gwc.components.editImageUpload', [
                                    'label' => $label,
                                    'name' => $field,
                                    'value' => $resource->$field,
                                    'required' => true,
                                    'folder' => $data['imageFolder'] . '/thumb/',
                                    'deletePath' => 'gwc/' . $data['path'] . '/deleteimage/' . $field,
                                ]) @endcomponent
                            </div>
                        </div>

                    </div>

                    @component('gwc.templateIncludes.formFooter') @endcomponent

                </div>
            </div>
        </div>
    </form>
@endsection