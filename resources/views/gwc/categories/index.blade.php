@extends('gwc.template.indexTemplate')

@section('indexContent')
    @if(count($resources))
        <div class="kt-list-timeline">
            <div class="kt-list-timeline__items">
                <div class="font-weight-bold kt-list-timeline__item">
                    <span class="kt-list-timeline__text">{{__('adminMessage.categoryname')}}</span>

                    <span class="kt-list-timeline__time">{{__('adminMessage.image')}}</span>
                    <span class="kt-list-timeline__time text-center">Second image</span>

                    <span class="kt-list-timeline__time text-center">{{__('adminMessage.active')}}</span>
                    <span class="kt-list-timeline__time">{{__('adminMessage.sorting')}}</span>
                    <span class="kt-list-timeline__time">{{__('adminMessage.actions')}}</span>
                </div>
            </div>
            @foreach($resources as $category)
                <div class="kt-list-timeline__items">
                    <div class="kt-list-timeline__item">
                        <span class="kt-list-timeline__badge"></span>
                        <span class="kt-list-timeline__text"><h5>{{$category->title . '( '. $category->translate('ar')->title . ' )'}}</h5></span>
                        <span class="kt-list-timeline__time">
                                                        @if($category->image)
                                <img width="30" src="{{$category->image}}" alt="">
                            @endif
                                                        </span>
                        <span class="kt-list-timeline__time">
                                                        @if($category->second_image)
                                <img width="30" src="{{$category->second_image}}" alt="">
                            @endif
                                                        </span>
                        <span class="kt-list-timeline__time">
                                                        <span class="kt-switch"><label><input value="{{$category->id}}"
                                                                                              {{!empty($category->is_active)?'checked':''}} type="checkbox"
                                                                                              id="category"
                                                                                              class="change_status"><span></span></label></span>
                                                        </span>
                        <span class="kt-list-timeline__time">{{$category->display_order}}</span>
                        <span class="kt-list-timeline__time">
                                                    <span style="overflow: visible; position: relative; width: 80px;">
                            <div class="dropdown">
                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                   data-toggle="dropdown">
                                    <i class="flaticon-more-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        @if(auth()->guard('admin')->user()->can($data['editPermission']))
                                            <li class="kt-nav__item">
                                                <a href="{{url($data['url'] . $category->id . '/edit')}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-shopping-cart"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.edit')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth()->guard('admin')->user()->can($data['deletePermission']))
                                            <li class="kt-nav__item">
                                                <a href="javascript:;" data-toggle="modal"
                                                   data-target="#kt_modal_{{$category->id}}" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-trash"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.delete')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </span>


                            <!--Delete modal -->
 <div class="modal fade" id="kt_modal_{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">{{__('adminMessage.alert')}}</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											</button>
										</div>
										<div class="modal-body">
											<h6 class="modal-title text-left">{!!__('adminMessage.alertDeleteMessage')!!}</h6>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('adminMessage.no')}}</button>
											<button type="button" class="btn btn-danger"
                                                    onClick="Javascript:window.location.href='{{url('gwc/category/delete/'.$category->id)}}'">{{__('adminMessage.yes')}}</button>
										</div>
									</div>
								</div>
							</div>
                                                        </span>
                    </div>
                    @if(count($category->childrenRecursive) > 0)
                        @include('gwc.partials.IndexCategory',['categories' => $category->childrenRecursive, 'level'=>0])
                    @endif
                    <div class="kt-separator kt-separator--space-sm kt-separator--border-dashed"></div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center">No Record(s) Found</div>
    @endif
@endsection




