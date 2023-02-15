<div class="kt-subheader kt-grid__item" id="kt_subheader">
    <div class="kt-container kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">{{ $data['subheader1'] }}</h3>
            <span class="kt-subheader__separator kt-hidden"></span>
            <div class="kt-subheader__breadcrumbs">
                <a href="{{url('gwc/home')}}" class="kt-subheader__breadcrumbs-home">
                    <i class="flaticon2-shelter"></i>
                </a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="javascript:;" class="kt-subheader__breadcrumbs-link">
                    {{ $data['newTitle']??$data['headTitle'] }}
                </a>
            </div>
        </div>
    </div>
</div>