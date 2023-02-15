@extends('front.layouts.master')
@section('subTitle' , getSingle('TermsConditions')['title_'.$lang])
@section('head')
    <link rel="stylesheet" href="{{asset('front_assets/assets/css/'. ($lang=='en'?'main.css':'main-ar.css'))}}">
@stop
@section('content')
    <div class="text-center text-white" style="padding-top: 30px;text-align: center">
        <a href="../index9ed2.html?lang=en" id="landing-page"><img
                    src="{{'/uploads/settings/'. getSetting('setting')->logo}}" img class="img-fluid"></a>
    </div>
    <div class="container" style="min-height: 500px">
        <div class="col-12" style="font-size: 25px; padding: 50px 0 0 0;">
            {{getSingle('TermsConditions')['title_'.$lang]}}
        </div>
        <div class="col-12" style="margin-top: 40px;margin-left: 10px;font-size: 14px;line-height: 2.3;">
            {!! getSingle('TermsConditions')['details_'.$lang] !!}
        </div>
    </div>
@stop

