<div class="kt-portlet__head-toolbar">
    <div class="kt-portlet__head-wrapper">
        <div class="kt-portlet__head-actions">
            @if(auth()->guard('admin')->user()->can($data['listPermission']))
                <a href="{{url($data['url'])}}" class="btn btn-brand btn-elevate btn-icon-sm">
                    <i class="la la-list-ul"></i>
                    {{ $data['listTitle'] }}
                </a>
            @endif
        </div>
    </div>
</div>