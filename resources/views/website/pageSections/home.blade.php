<div class="banner-area black-bg-5 pt-65">
    <div class="container">
        <div class="row">

            @foreach($packages as $package)
                <div class="col-lg-6 col-md-6">
                    <div class="devita-product-2 devita-product-game">
                        <div class="banner-img banner-hover banner-mrg">
                            <a href="#">
                                <img alt="" src="{{ asset('/uploads/packages/' . $package->cover_image) }}">
                            </a>
                        </div>
                        <p>&nbsp;</p>
                        <div class="product-content text-center">
                            @php
                            $duration = \App\Duration::find($package->duration_id);
                            $duration = $duration->{'title_'.$lang}
                            @endphp
                            <span>{{$duration}}</span>
                            <h4>
                                <a href="{{ url('/details/' . $package->code) }}">
                                    {{ $package->{'title_'.$lang} }}
                                </a>
                            </h4>
                            <div class="product-price-wrapper">
                                <span>
                                    KD {{ $package->price }}
                                </span>
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="product-action">
{{--                            <a class="action-cart" title="View Details" href="{{ url('/details/' . $package->code) }}">--}}
{{--                                View Details--}}
{{--                            </a>--}}
                            &nbsp;&nbsp;&nbsp;
                            <a class="action-cart" title="Subscribe" href="{{ url('/subscribe/' . $package->code) }}">
                                Subscribe
                            </a>
                        </div>
                        <p>&nbsp;</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>