<div class="kt-subheader kt-grid__item" id="kt_subheader">
    <div class="kt-container kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">@yield('subheader1',$data['subheader1'])</h3>
            <span class="kt-subheader__separator kt-hidden"></span>
            <div class="kt-subheader__breadcrumbs">
                <a href="{{url('gwc/home')}}" class="kt-subheader__breadcrumbs-home">
                    <i class="flaticon2-shelter"></i>
                </a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="javascript:;" class="kt-subheader__breadcrumbs-link">
                    @yield('subheader2',$data['subheader2'])
                </a>
            </div>
        </div>
        
        <div class="kt-subheader__toolbar">

            <!-- reset filtration button -->
            @if(Request()->query->count()>0)
                <a href="{{Request()->url()}}" type="button" class="btn btn-danger btn-bold mx-2">{{__('adminMessage.reset')}}</a>
            @endif

            <!-- filter date -->
            <form class="" id="kt_subheader_search_form" method="get">
            <div class="kt-subheader__wrapper mx-2">
                <div class="kt-input-icon kt-input-icon--right kt-subheader__search" style="width: fit-content">
                    <input type="text" class="form-control"  name="kt_daterangepicker_range" id="kt_daterangepicker_range" placeholder="Select Date Range"
                           value="@if(Request()->input('kt_daterangepicker_range')){{Request()->input('kt_daterangepicker_range')}}@endif">
                    <button type="submit" style="border:0;" class="kt-input-icon__icon kt-input-icon__icon--right">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
            </form>

            @yield('searchHeader')

            <!-- search box -->
            <form class="mx-2" id="kt_subheader_search_form" method="get">
                <div class="kt-input-icon kt-input-icon--right kt-subheader__search">
                    <input value="{{Request()->q}}" type="text" class="form-control"
                           placeholder="{{__('adminMessage.searchhere')}}" id="q" name="q">
                    <button style="border:0;" class="kt-input-icon__icon kt-input-icon__icon--right">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1"
                             class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg>
                    </span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>