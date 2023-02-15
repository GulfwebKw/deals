@extends('front.layouts.master')
@section('subTitle' , trans('webMessage.signup'))
@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/bootstrap.min.css')}}">
    <script src="{{asset('front_assets/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front_assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/login.css')}}">
    @stop
@section('content')
    <div id="register">
        <div class="text-center text-white pt-5">
            <a href="/" id="landing-page"><img src="{{'/uploads/settings/'. getSetting('setting')->logo}}" img class="img-fluid"></a>
        </div>
        <div class="container">
            <div id="register-row" class="row justify-content-center align-items-center">
                <div id="register-column" class="col-md-10">
                    <div id="register-box" class="col-md-12">
                        <form id="register-form" class="form" action="{{route('register.store')}}" method="post">
                            @csrf
                            <h3 class="text-center text-info">{{__('site.signup')}}</h3>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="bg-danger text-center p-2 text-white">{{$error}}</div>
                                @endforeach
                            @endif
                            @if ( old('codeValidation' , false ) )
                                <input type="hidden" name="full_name" value="{{ old("full_name") }}">
                                <input type="hidden" name="username" value="{{ old("username") }}">
                                <input type="hidden" name="email" value="{{ old("email") }}">
                                <input type="hidden" name="phonenumber" value="{{ old("phonenumber") }}">
                                <input type="hidden" name="password" value="{{ old("password") }}">
                                <input type="hidden" name="password_confirmation" value="{{ old("password_confirmation") }}">
                                <input type="hidden" name="codeValidation" value="{{ old("codeValidation") }}">

                                <div class="row">
                                    <div class="col-md-8 english-name">
                                        <div class="form-group">
                                            <label for="lastname" class="text-info">{{__('webMessage.passcode_required')}}:</label><br>
                                            <input type="text" name="code" id="code" placeholder="{{__('webMessage.passcode_required')}}" class="form-control " value="{{ old("code") }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="resendcode" style="display: none;">
                                        <div class="form-group">
                                            <label onclick="submitForm();" class="text-info" style="margin-top: 32px;cursor: pointer;"><i class="fa fa-redo-alt" style="font-size: 1.4em;margin-right: 10px;margin-left: 10px;"></i>{{trans('webMessage.ResendCode')}}</label>
                                            <input type="checkbox" name="resend" id="resend" value="1" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            @else
                            <div class="row">
                                <div class="col-md-6 english-name">
                                    <div class="form-group">
                                        <label for="lastname" class="text-info">{{__('site.full_name')}}:</label><br>
                                        <input type="text" name="full_name" id="full_name" placeholder="{{__('site.full_name')}}" class="form-control " value="{{ old("full_name") }}">
                                    </div>
                                </div>
                                <div class="col-md-6 english-name">
                                    <div class="form-group">
                                        <label for="lastname" class="text-info">{{__('site.username')}}:</label><br>
                                        <input type="text" name="username" id="username" placeholder="{{__('site.username')}}" class="form-control " value="{{ old("username") }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="text-info">{{__('site.email')}}:</label><br>
                                        <input type="email" id="email" placeholder="{{__('site.email')}}" class="form-control " name= "email" value="{{ old("email") }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phonenumber" class="text-info">{{__('site.phone_number')}}:</label><br>
                                        <input type="text" id="phonenumber" name="phonenumber" placeholder="{{__('site.phone_number')}}" class="form-control " value="{{ old("phonenumber") }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="text-info">{{__('site.password')}}:</label><br>
                                        <input type="password" name="password" id="password" placeholder="{{__('site.password')}}" class="form-control " value="{{ old("password") }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="text-info">{{__('site.confirm_password')}}:</label><br>
                                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{__('site.confirm_password')}}" value="{{ old("password_confirmation") }}" class="form-control ">
                                    </div>
                                </div>
                            </div>

                            @endif
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="form-group mb-0">
                                        <input type="submit" name="submit" class="btn btn-md btn-submit" value="{{__('site.signup')}}" id="register-btn">
                                    </div>
                                    <div id="login-link" class="register-here">
                                        <a href="{{route('login.index')}}" class="text-info">{{__('site.login')}}</a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        function submitForm(){
            $( "#resend" ).attr("checked" , true);
            var form = document.createElement("form");
            var myForm = document.getElementById("register-form");
            form.submit.apply(myForm);
        }

        setTimeout(
            function() {
                $( "#resendcode" ).show();
            }, 10000);
    </script>
@endsection