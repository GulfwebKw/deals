<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{getSetting('setting')['name_'. $lang]}}@hasSection('subTitle') - @yield('subTitle')@endif</title>
    <meta name="description" content="{{getSetting('setting')['seo_description_'. $lang]}}">
    <meta name="keywords" content="{{getSetting('setting')['seo_keywords_'. $lang]}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{{--    <link rel="manifest" href="site.html">--}}
    <link rel="shortcut icon" href="{{asset('/uploads/settings/'.getSetting('setting')->favicon)}}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/6212ad085b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{asset('front_assets/assets/css/aos.css')}}"/>
    <link rel="stylesheet" href="{{asset('front_assets/assets/css/fade-aniamtion.css')}}"/>
    <link href="{{asset('front_assets/assets/css/animation-style.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('front_assets/assets/css/hover.css')}}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/assets/css/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/assets/css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/assets/css/normalize.css')}}">
    @yield('main')
    <link type="text/css" rel="stylesheet" href="{{asset('front_assets/assets/css/responsive.css')}}" />
    <link rel="stylesheet" href="{{asset('front_assets/assets/css/menu.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700" rel="stylesheet">


    @yield('head')
</head>
<body style="text-align: {{$lang=='en'?'left':'right'}} !important;direction: {{$lang=='en'?'ltr':'rtl'}}">
<section id="wrapper">
@yield('content')
{{--@include('front.layouts.footer')--}}
</section>
<script src='{{asset('/front_assets/js/jquery.min.js')}}'></script>
<script src="{{asset('/front_assets/assets/js/index.js')}}"></script>
<script src="{{asset('/front_assets/assets/js/main.js')}}"></script>
<script src="{{asset('/front_assets/assets/js/slick.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('/front_assets/assets/js/jquery.scroller.js')}}"></script>
<script src="{{asset('/front_assets/assets/js/jquery.scroller.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#nav').onePageNav();
    });
</script>
<script src="{{asset('/front_assets/assets/js/jquery-parallax.js')}}"></script>
{{--<script src="{{asset('/front_assets/js/TweenMax.min.js')}}"></script>--}}
<script src="{{asset('/front_assets/assets/js/aos.js')}}"></script>
{{--<script>--}}
{{--    AOS.init({--}}
{{--        easing: 'ease-in-out-sine'--}}
{{--    });--}}
{{--</script>--}}
<script src="{{asset('/front_assets/assets/js/jquery.superslides.js')}}" type="text/javascript" charset="utf-8"></script>
<script>
    $('#slides').superslides({
        animation: 'fade',
        play: 4000,
        delay: 4000,

    });

</script>
<script src="{{asset('/front_assets/assets/js/fade-animation.js')}}"></script>
<script type="text/javascript" src="{{asset('/front_assets/assets/js/delighters.js')}}"></script>
{{--<script src="{{asset('/front_assets/js/TweenMax.min.js')}}"></script>--}}
{{--<script>--}}
{{--    $( document ).mousemove( function( e ) {--}}
{{--        $( '.sec-top' ).parallax( -30, e );--}}
{{--        $( '.row' ).parallax( 20  , e );--}}
{{--        $( '.left-man' ).parallax( 10, e );--}}
{{--        $( '.mobile' ).parallax( 20   , e );--}}
{{--        $( '.phone-right' ).parallax( 20, e );--}}
{{--        $( '.abt-left-bg' ).parallax( 20   , e );--}}
{{--        $( '.right-man' ).parallax( 30   , e );--}}


{{--    });--}}
{{--</script>--}}
<script src="{{asset('/front_assets/js/vivus.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('.banner-slider').slick({
            dots: false,
            infinite: true,
            autoplay:true,
            speed: 500,
            fade: false,
            cssEase: 'linear',

            pauseOnHover: false,
        });

    });




</script>
<script type="text/javascript">
    $(document).ready(function() {
        localStorage.setItem("language", "en");
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav',
            dots: false,
            autoplay:true
        });
        $('.slider-nav').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: true,
            infinite: true,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true,
                    }
                },
                {
                    breakpoint: 639,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        dots: true,

                    }
                },
                {
                    breakpoint: 639,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });




</script>
<script>
    function easeOutBounce (x) {
        var base = -Math.cos(x * (0.5 * Math.PI)) + 1;
        var rate = Math.pow(base,1.5);
        var rateR = Math.pow(1 - x, 2);
        var progress = -Math.abs(Math.cos(rate * (2.5 * Math.PI) )) + 1;
        return (1- rateR) + (progress * rateR);
    }

    var timing,
        timingProps = {
            type: 'delayed',
            duration: 200,
            start: 'autostart',
            pathTimingFunction: Vivus.LINEAR,
            animTimingFunction: Vivus.LINEAR
        };




    // function timingTest (buttonEl, property, type) {
    //     var activeSibling = buttonEl.parentNode.querySelector('button.active');
    //     activeSibling.classList.remove('active');
    //     buttonEl.classList.add('active');
    //
    //     timingProps.type = (property === 'type') ? type : timingProps.type;
    //     timingProps.pathTimingFunction = (property === 'path') ? Vivus[type] : timingProps.pathTimingFunction;
    //     timingProps.animTimingFunction = (property === 'anim') ? Vivus[type] : timingProps.animTimingFunction;
    //
    //     timing && timing.stop().destroy();
    //     timing = new Vivus('timing-example', timingProps);
    // }

    var hi = new Vivus('hi-there', {type: 'scenario-sync', duration: 20, start: 'autostart', dashGap: 20, forceRender: false},
            function () {
                if (window.console) {
                    console.log('Animation finished. [log triggered from callback]');
                }
            }),
        obt1 = new Vivus('obturateur1', {type: 'delayed', duration: 300}),
        obt2 = new Vivus('obturateur2', {type: 'delayed', duration: 300}),
        obt3 = new Vivus('obturateur3', {type: 'delayed', duration: 300}),
        obt4 = new Vivus('obturateur4', {type: 'delayed', duration: 500}),
        obt5 = new Vivus('obturateur5', {type: 'delayed', duration: 200}),
        obt6 = new Vivus('obturateur6', {type: 'delayed', duration: 800}),
        pola = new Vivus('polaroid', {type: 'scenario-sync', duration: 30, forceRender: false});
</script>
<!-- Sticky nav -->
<script>
    $(window).scroll(function() {
        if ($(this).scrollTop() > 133) {
            $('header').addClass("is-sticky");

        }
        else {
            $('header').removeClass("is-sticky");
        }
    });
</script>
<script>
    // TOGGLE HAMBURGER & COLLAPSE NAV
    $('.nav-toggle').on('click', function() {
        $(this).toggleClass('open');
        $('.menu-left').toggleClass('collapse');
    });
    // REMOVE X & COLLAPSE NAV ON ON CLICK
    $('.menu-left a').on('click', function() {
        $('.nav-toggle').removeClass('open');
        $('.menu-left').removeClass('collapse');
    });

</script>
@yield('script')

</body>
</html>