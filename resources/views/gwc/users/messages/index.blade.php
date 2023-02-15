@extends('gwc.template.viewTemplate')
@section('header-style')
    <link href="{!! asset('admin_assets/assets/css/style.chat.css') !!}" rel="stylesheet" type="text/css"/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
@endsection
@section('viewContent')
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
                <!--begin::Contacts-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header pt-7" id="kt_chat_contacts_header">
                        <!--begin::Form-->
                        <form class="w-100 position-relative" autocomplete="off">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
															<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
														</svg>
													</span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid px-15" name="search" value="" placeholder="Search by username or email..." onkeyup="searchInside($(this).val());"/>
                            <!--end::Input-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-5" id="kt_chat_contacts_body">
                        <!--begin::List-->
                        <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="5px" style="overflow: auto;height: calc(100vh - 365px) !important;">
                        @if(count($resources))
                            @foreach($resources as $key=>$resource)
                                <!--end::User-->
                                <!--begin::User-->
                                <div class="d-flex flex-stack py-4 userBox">
                                    <!--begin::Details-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-45px symbol-circle">
{{--                                            <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">M</span>--}}
                                            <img alt="Pic" src="{{$resource['resources']->last()->freelancer->image}}">
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="ms-5">
                                            @if(auth()->guard('admin')->user()->can($data['viewPermission']))
                                                <a href="#" onclick="ajaxRunUrlHtml('{{url($data['url'] . 'freelancer/' . $resource['resources'][0]->freelancer_id . '/messages')}}')" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2 userBoxName">{!! $key !!}</a>
                                            @else
                                                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2 userBoxName">{!! $key !!}</a>
                                            @endif
                                            <div class="fw-bold text-muted">{{ substr($resource['resources']->last()->message,0,10) }}</div>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Details-->
                                    <!--begin::Lat seen-->
                                    <div class="d-flex flex-column align-items-end ms-2">
                                        <span class="text-muted fs-7 mb-1"  title="{{ $resource['resources']->last()->created_at }}">{{ Carbon\Carbon::parse($resource['resources']->last()->created_at )->diffForHumans(Carbon\Carbon::now()) }}</span>
                                        @if($resource['status']==0) <span class="badge badge-sm badge-circle badge-light-danger"><i class="fas fa-check"></i></span>
                                        @else <span class="badge badge-sm badge-circle badge-light-success"><i class="fas fa-check-double"></i></span>
                                        @endif
                                    </div>
                                    <!--end::Lat seen-->
                                </div>
                                <!--end::User-->
                                @if ( ! $loop->last )
                                <!--begin::Separator-->
                                <div class="separator separator-dashed d-none"></div>
                                <!--end::User-->
                                @endif
                            @endforeach
                        @else
                                <div class="d-flex align-items-center">
                                    {{__('adminMessage.recordnotfound')}}
                                </div>
                        @endif
                        </div>
                        <!--end::List-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Contacts-->
            </div>
            <!--end::Sidebar-->
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10" id="list_of_all_message">

            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
        <!--begin::Modals-->
    </div>
    <!--end::Container-->

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  id="quotationShow">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quotation:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="QuotationBody">

                </div>
            </div>
        </div>
    </div>
    <script>
        function searchInside(data){
            if ( data != "" ){
                $('.userBox').attr('style', 'display: none !important');
                $(".userBoxName").each(function() {

                    if ($(this).text().match(data)) {
                        $(this).parent().parent().parent().attr('style', 'display: flex !important');
                    }
                });
            } else {
                $('.userBox').attr('style', 'display: flex !important');
            }



        }
        function openQuotation(link){
            $.ajax({
                url: link,
                type: 'get',
                dataType: 'html',
                success: function (html) {
                    if (html) {
                       $("#QuotationBody").html(html);
                       $('#quotationShow').modal('show');
                    }
                    else {
                        return false;
                    }
                }
            });
            return false;
        }
        function ajaxRunUrlHtml(link) {
            $.ajax({
                url: link,
                type: 'get',
                dataType: 'html',
                success: function (html) {
                    if (html) {
                        var result = $('<div />').append(html).find('#list_of_all_message').html();
                        $('#list_of_all_message').html(result);
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            });
            return false;
        }
        @if(count($resources) and ! request()->has('freelancer_id'))
            @foreach($resources as $key=>$resource)
                document.addEventListener("DOMContentLoaded", function(){
                    ajaxRunUrlHtml('{{url($data['url'] . 'freelancer/' . $resource['resources'][0]->freelancer_id . '/messages')}}')
                });
                @break
            @endforeach
        @elseif (request()->has('freelancer_id') )
            document.addEventListener("DOMContentLoaded", function(){
                ajaxRunUrlHtml('{{url($data['url'] . 'freelancer/' . request()->freelancer_id . '/messages')}}')
            });
        @endif
    </script>
@endsection