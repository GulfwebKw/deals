@extends('website.master')

@section('content')

    <div id="wrapper">
        <header id="page-title" class="nopadding">
            <div id="gmap" class="unsupported"></div>
        </header>
        <section id="contact" class="container">
            <div class="row">
                @include('website.pageSections.contactusForm')
                @include('website.pageSections.contactusInfo')
            </div>
        </section>
    </div>

@endsection
