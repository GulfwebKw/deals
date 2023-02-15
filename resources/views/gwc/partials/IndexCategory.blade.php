<div class="kt-list-timeline__items">

    @foreach($categories as $child)

        <div class="kt-list-timeline__item">
            @for ($i = 0; $i <= $level; $i++)
                <span class="kt-list-timeline__badge"></span>
            @endfor
            <span class="kt-list-timeline__text">{{$child->title . '( '. $child->translate('ar')->title . ' )'}}</span>

            <span class="kt-list-timeline__time">
         @if($child->image)
                    <img width="30" src="{{$child->image}}" alt="">
                @endif
         </span>
            <span class="kt-list-timeline__time">
         <span class="kt-switch"><label><input value="{{$child->id}}" {{!empty($child->is_active)?'checked':''}} type="checkbox"  id="category" class="change_status"><span></span></label></span>
         </span>
            <span class="kt-list-timeline__time">{{$child->display_order}}</span>
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
                                                <a href="{{url($data['url'] . $child->id . '/edit')}}"
                                                   class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-shopping-cart"></i>
                                                    <span class="kt-nav__link-text">{{__('adminMessage.edit')}}</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if(auth()->guard('admin')->user()->can($data['deletePermission']))
                                            <li class="kt-nav__item">
                                                <a href="javascript:;" data-toggle="modal"
                                                   data-target="#kt_modal_{{$child->id}}" class="kt-nav__link">
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
 <div class="modal fade" id="kt_modal_{{$child->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
											<button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('adminMessage.no')}}</button>
											<button type="button" class="btn btn-danger"  onClick="Javascript:window.location.href='{{url('gwc/category/delete/'.$child->id)}}'">{{__('adminMessage.yes')}}</button>
										</div>
									</div>
								</div>
							</div>
                                                        </span>
        </div>
        <div class="kt-separator kt-separator--space-sm kt-separator--border-dashed"></div>
                    @if(count($child->childrenRecursive) > 0)
                        @include('gwc.partials.IndexCategory',['categories' => $child->childrenRecursive, 'level'=>($level+1)])
                    @endif
    @endforeach
</div>
