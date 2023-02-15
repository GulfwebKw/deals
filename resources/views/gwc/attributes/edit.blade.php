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

                                                @component('gwc.components.editTextInput', [
                                                    'label' => 'Name ( '. $lang->key . ' )',
                                                    'name' => 'title_' . $lang->key,
                                                    'value'=>json_decode($resource->value, true)[$lang->key],
                                                    'required' => true
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
        </div>

        @component('gwc.templateIncludes.createEditFooter', ['url' => $data['url']]) @endcomponent

    </form>
@endsection