@extends('gwc.template.viewTemplate')

@section('viewContent')
    <div class="kt-widget kt-widget--user-profile-3">
        <div class="kt-widget__top">
            <div class="kt-widget__content">
                <div class="kt-widget__head">
                    <div class="kt-widget__user">
                        <h2>{{$resume->name}}</h2>
                    </div>
                </div>
                <div class="kt-widget__subhead">
                    <a href="javascript:;">
                        <i class="flaticon2-new-email"></i>
                        {{$resume->email}}
                    </a>
                    <a href="javascript:;">
                        <i class="flaticon2-edit"></i>
                        {{$resume->subject}}
                    </a>
                </div>
                <div style="margin-bottom: 10px">
                    <span style="font-weight: bold">
                        {{ __('adminMessage.cv_file') }} &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;
                    </span>
                    <a href="{{ '/uploads/resumes/' . $resume->file }}" download>
                        <i class="flaticon2-download" style="font-size: 20px"></i>
                        {{$resume->file}}
                    </a>
                </div>
                <div class="kt-widget__info">
                    <div class="kt-widget__desc">
                        {{$resume->message}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection