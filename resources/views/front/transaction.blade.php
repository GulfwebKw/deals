@extends('front.layouts.master')
@section('subTitle' , trans('webMessage.transactiondetails'))
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/site_assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/bootstrap.min.css')}}">
    <script src="{{asset('front_assets/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front_assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/login.css')}}">
@stop
@section('content')
    @include('website.pageSections.transactionResult')
@endsection
