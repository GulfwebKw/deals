<div class="col-md-4">
    <h2>{{ __('site.contact_us') }}</h2>
    <p>
        {{ __('site.We_are_always_happy_to_hear_from_you') }}
    </p>
    <div class="divider styleColor half-margins">
        <i class="fa fa-info"></i>
    </div>
    <p>
        <span class="block">
            <strong><i class="fa fa-map-marker"></i>{{ __('site.address') }}</strong>
            <div class="tabbed">{!! $settings->{'address_'.$lang} !!}</div>
        </span>
        <br>
        <span class="block">
            <strong><i class="fa fa-phone"></i>{{ __('site.phone') }}</strong>
            <br>
            <span class="tabbed">{{ $settings->phone }}</span>
        </span>
        <span class="block">
            <strong><i class="fa fa-print"></i>{{ __('site.fax') }}</strong>
            <br>
            <span class="tabbed">{{ $settings->fax }}</span>
        </span>
        <span class="block">
            <strong><i class="fa fa-envelope"></i>{{ __('site.email') }}</strong>
            <br>
            <span class="tabbed">
                <a href="{{ 'mailto:' . $settings->email}}">
                    {{$settings->email}}
                </a>
            </span>
        </span>
    </p>
</div>