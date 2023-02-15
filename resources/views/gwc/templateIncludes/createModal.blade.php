<div class="modal fade" id="kt_modal" tabindex="-1" role="dialog" aria-labelledby="kt_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$data['subheader2']}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><!--begin::Form-->
                @if(auth()->guard('admin')->user()->can($data['createPermission']))
                    <form name="tFrm" id="form_validation" method="post"
                          class="kt-form" enctype="multipart/form-data" action="{{route($data['storeRoute'])}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">{{__('adminMessage.isactive')}}</label>
                                        <div class="col-3">
														<span class="kt-switch">
															<label>
																<input type="checkbox" checked="checked" name="is_active"  id="is_active" value="1"/>
																<span></span>
															</label>
														</span>
                                        </div>
                                        <label class="col-3 col-form-label">{{__('adminMessage.displayorder')}}</label>
                                        <div class="col-3">
                                            <input type="text" class="form-control @if($errors->has('display_order')) is-invalid @endif" name="display_order"  value="{{old('display_order')?old('display_order'):$lastOrder}}" autocomplete="off" />
                                            @if($errors->has('display_order'))
                                                <div class="invalid-feedback">{{ $errors->first('display_order') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--categories name -->
                            <div class="form-group">

                                <label>{{__('adminMessage.title_en')}}</label>
                                <input type="text" class="form-control @if($errors->has('title_en')) is-invalid @endif" name="title_en"
                                       value="{{old('title_en')}}" autocomplete="off" placeholder="{{__('adminMessage.enter_title_en')}}*" />
                                @if($errors->has('title_en'))
                                    <div class="invalid-feedback">{{ $errors->first('title_en') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>{{__('adminMessage.title_ar')}}</label>
                                <input type="text" class="form-control @if($errors->has('title_ar')) is-invalid @endif" name="title_ar"
                                       value="{{old('title_ar')}}" autocomplete="off" placeholder="{{__('adminMessage.enter_title_ar')}}*" />
                                @if($errors->has('title_ar'))
                                    <div class="invalid-feedback">{{ $errors->first('title_ar') }}</div>
                                @endif

                            </div>

                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-success">{{__('adminMessage.save')}}</button>
                                <button type="button" onClick="Javascript:;" data-dismiss="modal" aria-label="Close"  class="btn btn-secondary cancelbtn">{{__('adminMessage.cancel')}}</button>
                            </div>
                        </div>
                    </form>

                @else
                    <div class="alert alert-light alert-warning" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                        <div class="alert-text">{{__('adminMessage.youdonthavepermission')}}</div>
                    </div>
            @endif
            <!--end::Form--></p>
            </div>

        </div>
    </div>
</div>