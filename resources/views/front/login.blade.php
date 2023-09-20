@extends('front.layouts.master')
@section('subTitle' , trans('webMessage.login'))
@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/bootstrap.min.css')}}">
    <script src="{{asset('front_assets/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front_assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/login.css')}}">
    @stop
@section('content')
    <div id="login">
        <div class="text-center text-white pt-5">
            <a href="/" id="landing-page"><img src="{{'/uploads/settings/'. getSetting('setting')->logo}}" img class="img-fluid"></a>

        </div>
        <div class="container">
            <div id="login-row" class="row pt-130 justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        @if(Session::has('success'))
                            <p class="alert  alert-info">{{ Session::get('success') }}</p>
                        @endif
                        <form id="login-form" class="form" action="{{route('login.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="text-info">{{__('site.email')}}:</label><br>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">{{__('site.password')}}:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info remember"><span>{{__('site.remember_me')}}</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="{{__('site.submit')}}">
                            </div>
                            <div id="register-link" class="register-here">
                                <a href="{{route('register.index')}}" class="text-info">{{__('site.register')}}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop