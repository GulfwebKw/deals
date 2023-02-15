<header class="header-area bg-img" style="background-image:url({{ asset('site_assets/img/bg/bg-14.jpg') }});">
    <div class="header-middle ptb-37">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 text-center">
                    <div class="logo logo-mrg">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('site_assets/img/logo/logo-4.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-bottom header-bottom-color-4 theme-bg-3 menu-hover-red">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="logo mobile-logo center">
                        <a href="{{ url('/') }}">
                            <img alt="" src="{{ asset('site_assets/img/logo/logo.png') }}">
                        </a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mobile-menu-area">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul class="menu-overflow">
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="{{ url('/trackorder') }}">Track Order</a></li>
                                    <li><a href="{{ url('/about') }}">About</a></li>
                                    <li><a href="{{ url('/contact') }}"> Contact us </a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-menu main-none text-center">
                <nav>
                    <ul>
                        <li class="mega-menu-position"><a href="{{ url('/') }}">Home</a></li>
                        <li class="mega-menu-position"><a href="{{ url('/trackorder') }}"> Track Order</a></li>
                        <li><a href="{{ url('/about') }}">About</a></li>
                        <li><a href="{{ url('/contact') }}">contacts us</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>