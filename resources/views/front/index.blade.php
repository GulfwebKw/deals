@extends('front.layouts.master')
@section('subTitle' , trans('webMessage.homeSubtitle'))
@section('main')
    <link rel="stylesheet" href="{{asset('front_assets/assets/css/'. ($lang=='en'?'main.css':'main-ar.css'))}}">
    <script src="https://sdk.pushy.me/web/1.0.8/pushy-sdk.js"></script>
    <script>

        // Register visitor's browser for push notifications
        Pushy.register({ appId: "{{ $settings->pushy_app_id }}"  })
            .then(function(deviceToken) {
                // Print device token to console
                console.log("Pushy device token: " + deviceToken);

                // Send the token to your backend server via an HTTP GET request
                //fetch('https://your.api.hostname/register/device?token=' + deviceToken);

                fetch('https://v1.dealsco.app/api/push-message-token/' + deviceToken)
                    .then(response => console.log(`TOKEN ${response.ok ? '' : 'NOT'} SAVED!`))

                // Succeeded, optionally do something to alert the user
            })
            .catch(function(err) {
                // Handle registration errors
                console.error(err);
            });
    </script>
@stop
@section('content')
    @if(Session::has('success'))
        <p class="alert  alert-ss">{{ Session::get('success') }}</p>
        @endif
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
    your browser</a>to improve your experience and security.</p>
<![endif]-->
<!-- Add your site or application content here -->
    <section class="main-warp">
        <section class="page">
            <header>
                <div class="social-media-top">
                    <ul class="media_top">
                        <!--
                           <li data-aos="fade-right">
                              <a href="https://www.facebook.com/deals.deals.3363" target="_blank"> <i class="fa fa-facebook "></i></a></li> -->
                        <li data-aos="fade-up"
                            data-aos-anchor-placement="bottom-bottom"><a href="https://twitter.com/dealskwt_"
                                                                         target="_blank"> <i class="fa fa-twitter"></i></a>
                        </li>
                        <li data-aos="fade-left"><a href="https://www.instagram.com/dealskwt/" target="_blank">
                                <i class="fa fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="container">
                    <div class="logo-sec main-nav">
                        <a href="#s0"></a>
                    </div>
                    <div class="menu">
                        <div class="lang">
                            <a href="{{'/set-locale/'. ($lang=='en'?'ar':'en')}}">{{$lang=='en'?'العربیه':'English'}}</a>
                            @if((Auth::guard('freelancer')->check() || Auth::guard('admin')->check()))
                            <a href="{{auth()->guard('freelancer')?'/freelancer':'/gwc/home'}}">{{$lang=='en'?'profile':'الملف الشخصي'}}</a>
                                @endif
                        </div>

                        <nav id="navigation" class="main-nav ">
                            <a aria-label="mobile menu" class="nav-toggle"> <span></span> <span></span> <span></span>
                            </a>
                            <ul id="nav" class="menu-left">
                                <li><a href="#s0">{{$lang=='en'?'Home':'الرئيسية'}}</a></li>
                                <li><a href="#s1">{{$lang=='en'?'About US':'من نحن؟'}}</a></li>
                                <li><a href="#s2">{{$lang=='en'?'Features':'مميزات'}}</a></li>
                                <li><a href="#s3">{{$lang=='en'?'How It Works':'كيف يعمل'}}</a></li>
                                <li><a href="#s4">{{$lang=='en'?'Benefits':''}}</a></li>
                                @if(!(Auth::guard('freelancer')->check() || Auth::guard('admin')->check()))

                                <li><a href="{{route('login.index')}}">{{$lang=='en'?'Login/SignUp':'الفوائد'}}</a></li>
                                @endif
                                <li><a href="#s6">{{$lang=='en'?'Contact Us':'تسجيل الدخول'}}</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </header>
            <section class="midd-wrap">
                <section id="s0" class="main-cont">
                    <section class="banner-part">
                        <section class=" sec-top">
                            <section class="row">
                                <section class="container">
                                    <article class="col-left">
                                        <div class="home-left">
                                            <!-- <div class="men-1"> <img src="images/right-man.png" alt="man" class="cloud left-man"> </div>-->
                                            <div class="mobile">
                                                <div class="mobile-image-slider">
                                                    <div class="screen-slide">
                                                        @if(getSingle('slider')->images)
                                                            <ul class="banner-slider">
                                                                @foreach(explode(',', getSingle('slider')->images) as $image)
                                                                    <li data-e="{{$image}}">
                                                                        <img src="{{asset('/uploads/singlepages/'.$image)}}"
                                                                             alt=""/>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!--  <div class="men-2"> <img src="images/left-man.png" alt="man" class="cloud right-man"> </div>-->
                                        </div>
                                    </article>
                                    <article class="col-right">
                                        <div class="top-heading" data-aos="fade-left">
                                            <h1>{!! getSingle('slider')['details_'.$lang] !!}</h1>
                                        </div>
                                        <div class="app-button right" data-delighter="start:0.8">
                                            <div class="btn hvr-float-shadow yellow"><a href="#"> <img
                                                            src="{{asset('front_assets/assets/images/btm-appstore-y.png')}}">
                                                </a></div>
                                            <div class="btn hvr-float-shadow white"><a href="#"> <img
                                                            src="{{asset('front_assets/assets/images/btm-playstore-w.png')}}">
                                                </a></div>
                                        </div>
                                    </article>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>
                <section id="s1" class="main-cont">
                    <section class="about-part">
                        <section class="container">
                            <section class="about-cont">
                                <article class="abt-left-bg">
                                    <article class="abt-left right" data-delighter="start:0.8">
                                        <h5>{{$lang=='en'?'About':'من نحن؟'}}</h5>
                                        <h2>{{getSingle('about')['title_'.$lang]}}</h2>
                                        {!! getSingle('about')['details_'.$lang] !!}
                                    </article>
                                    <article class="abt-right" data-aos="fade-down"
                                             data-aos-easing="linear"
                                             data-aos-duration="1500">
                                        <div class="phone-right"><img
                                                    src="{{asset('front_assets/assets/images/phone-right.png')}}"></div>
                                    </article>
                                </article>
                            </section>
                        </section>
                    </section>
                </section>
                <section id="s2" class="main-cont">
                    <section class="container">
                        <article class="features-cont right" data-delighter="start:0.8">
                            <h5>{{$lang=='en'?'Features':'الخصائص والمیزات'}}</h5>
                            {!! getSingle('features')['details_'.$lang] !!}
                        </article>
                        <article class="features-list animation-element slide-right">
                            <ul>
                                <div class="bloc bloc-head" style="display:none;">
                                    <svg height="300" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                         viewBox="0 0 408.7 354" enable-background="new 0 0 408.7 354" id="hi-there"
                                         onclick="hi.reset().play();"></svg>
                                </div>
                                @foreach($categories as $category)
                                    <li>
                                        <div class="col3">
                                            <img src="{{asset('uploads/categories/'.$category->image)}}">
                                            <img src="{{asset('uploads/categories/'.$category->image)}}">
                                        </div>
                                        <h4>{{optional($category->translate($lang))->title}}
                                        </h4>
                                    </li>
                                @endforeach
                            </ul>
                        </article>
                    </section>
                </section>


                <section id="s3" class="main-cont">
                    <section class="container">
                        <section class="steps">


                            <article class="slider-box left" data-delighter="start:0.8">
                                <article class="slider-left">
                                    <article class="phone-white">
                                        <div class="phone-slider">
                                            <ul class="slider-steps slider-for ">
                                                @foreach($sliders as $slider)
                                                    <li>
                                                        <img src="{{asset('/uploads/howitworks/'.$slider->image)}}">
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </article>
                                </article>
                                <article class="slider-right">
                                    <h4></h4>
                                    <ul class="slider-steps slider-nav">
                                        @foreach($sliders as $key=>$slider)
                                            <li>
                                                <div class="number">
                                                    <h1>{{$slider->display_number}}</h1>
                                                </div>
                                                <div class="step">
                                                    <h4>{{$slider->display_number . '. ' . optional($slider->translate($lang))->title}}</h4>
                                                    <h5>{{$slider->step . '. ' .optional($slider->translate($lang))->sub_title}}</h5>
                                                    <div class="text-dark">{{optional($slider->translate($lang))->description}}</div>
                                                </div>
                                            </li>

                                        @endforeach
                                    </ul>
                                </article>
                            </article>
                        </section>
                    </section>
                </section>


                <section id="s4" class="main-cont">
                    <section class="benifit-cont">
                        <section class="container">
                            <article class="benefits-box">
                                <div class="benefits-box-left right" data-delighter="start:0.8"></div>
                                <div class="benefits-box-right">
                                    <h5 class="left" data-delighter="start:0.8">{{$lang=='en'?'BENEFITS':'الفوائد'}}</h5>
                                    <h2 class="left" data-delighter="start:0.8">
                                        {{getSingle('benefits')['title_'. $lang]}}
                                    </h2>
                                    <div class="left" data-delighter="start:0.8">
                                        {!! getSingle('benefits')['details_'. $lang] !!}
                                    </div>
                                    <h2 class="left" data-delighter="start:0.8">{{$lang=='en'?'Expansion':'التوسع'}}</h2>
                                    <div class="left" data-delighter="start:0.8"> {!! getSingle('expansion')['details_'. $lang]!!} </div>
                                </div>
                            </article>
                        </section>
                    </section>
                </section>
                <!--
                   <section id="s5" class="main-cont" >
                     <section class="partner-sec">
                       <section class="container">
                         <article class="partners " data-delighter="start:0.8">
                           <h2>partners</h2>
                           <ul>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners1.jpg"> </a> </li>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners2.jpg"> </a> </li>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners3.jpg"> </a> </li>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners4.jpg"> </a> </li>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners3.jpg"> </a> </li>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners2.jpg"> </a> </li>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners3.jpg"> </a> </li>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners1.jpg"> </a> </li>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners3.jpg"> </a> </li>
                             <li> <a href="#"><img src="https://dev.dealsco.app/assets/images/partners1.jpg"> </a> </li>
                           </ul>
                         </article>
                       </section>
                     </section>
                   </section> -->


                <section id="s6" class="main-cont">
                    <section class="contact-cont">
                        <section class="container">
                            <article class="col-center right" data-delighter="start:0.8">
                                <div class="logo-btm main-nav "><a href="index-2.html"> <img
                                                src="{{asset('/uploads/settings/'.$settings->logo)}}"> </a></div>
                                <h6>Get in touch</h6>
                                <h3 style="padding-bottom: 20px;"><a href="mailto:info@dealsco.app">{{$settings->email}}</a></h3>

                                <p>Phone : {{$settings->phone}}</p>
                                <div class="social-media ">
                                    <br>
                                    <ul class="media">
                                        <!--                                     <li data-aos="fade-right"> <a href="https://www.facebook.com/deals.deals.3363" target="_blank"> <i class="fa fa-facebook "></i></a></li>
                                           -->
                                        <li data-aos="fade-up"
                                            data-aos-anchor-placement="bottom-bottom">
                                            <a href="{{$settings->social_twitter}}" target="_blank"> <i
                                                        class="fa fa-twitter"></i></a>
                                        </li>
                                        <li data-aos="fade-left"><a href="{{$settings->social_instagram}}"
                                                                    target="_blank">
                                                <i class="fa fa-instagram"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </article>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
        @include('front.layouts.footer')
@endsection