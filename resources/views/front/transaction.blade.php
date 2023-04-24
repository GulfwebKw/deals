@extends('front.layouts.master')
@section('subTitle' , trans('webMessage.transactiondetails'))
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/site_assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/bootstrap.min.css')}}">
    <script src="{{asset('front_assets/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front_assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/login.css')}}">
    <style>
        .white_text {
            color: #000000 !important;
        }
        .text-yellow {
            color: #ffb731 !important;
        }
        body {
            background-color: #ffffff !important;
        }
    </style>
@stop
@section('content')
    @include('website.pageSections.transactionResult')
@endsection
