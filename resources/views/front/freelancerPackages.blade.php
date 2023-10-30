@extends('front.layouts.master')
@section('subTitle' , trans('webMessage.homeSubtitle'))
@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/bootstrap.min.css')}}">
    <script src="{{asset('front_assets/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front_assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('front_assets/css/login.css')}}">
@stop
@section('content')
    <style>
        .headerText {
            text-align: center;
            color: #FFFFFF;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 500;
            font-family: 'Montserrat', sans-serif;
        }

        a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .name {
            color: #fff;
            padding-right: 15px;

        }

        .container {
            *margin-top: 15px;
        }


    </style>

    <style>
        .row {

            margin-right: 0px;
            margin-left: 0px;
        }

        .subscription-head {
            color: #072438;
            font-family: Roboto;
            font-size: 26px;
            font-weight: bold;
            line-height: 32px;
        }

        .subscription-page .arrow {
            margin-left: 2%;
            /*margin-top: 4%;*/
        }

        .subscription-page .subscription-box {
            border-radius: 4px;
            background-color: #FFFFFF;
            box-shadow: 0 12px 32px 0 rgba(0, 0, 0, 0.11);
            padding: 20px 10px 1px;
            /* margin: 0 auto; */
            /* margin-top: 10%; */
        }

        .subscription-page .same-line {
            display: inline-flex;
        }

        .subscription-page .month-plan {
            color: #072438;
            font-size: 20px;
            font-weight: bold;
            line-height: 32px;
        }

        .subscription-page .activate-plan {
            padding: 4px !important;
            background-color: #55C9D1;
            border: 1px solid #55c9d1;
            margin-left: 30px;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            border-radius: 14px;
        }

        .subscription-page .active-plan {
            padding: 4px !important;
            background-color: red;
            border: 1px solid #fff;
            margin-left: 30px;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            border-radius: 14px;
        }

        .subscription-page .cost {
            color: #55C9D1;
            font-size: 14px;
            font-weight: 500;
            line-height: 32px;
        }

        .subscription-page .kd-month {
            color: #072438;
            font-size: 40px;
            font-weight: bold;
            line-height: 66px;
        }

        .subscription-page .per-month {
            color: #072438;
            font-size: 14px;
            font-weight: bold;
            line-height: 32px;
        }

        .subscription-page .expiration {
            color: #EF666E;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: -0.35px;
            line-height: 19px;
        }

        .subscription-page .name {
            color: #072438;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: -0.35px;
            line-height: 19px;
            margin: auto !important;
        }

        .plans {
            padding-bottom: 25px;
        }

        .subscription-box .description {
            font-size: 12px;
            text-align: left;
            padding: 2px;
        }

        .subscription-box a:hover {
            color: #0c1e2c;
        }
    </style>
    <div id="login" class="container">
        <div class="row pt-3">
            <div class="col-6">
                <img src="{{'/uploads/settings/'. getSetting('setting')->logo}}" class="img-fluid">

            </div>
            <div class="col-6 text-right m-auto">
                <span class="name"> {{\Illuminate\Support\Facades\Auth::user()->name}} </span>
                <a class="headerText" href="{{route('logout')}}">Logout</a>
            </div>
        </div>

        <div class="container">
            <div class="subscription-page mt-4">
                <form method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 subscription-box mb-4 p-2 " style="display: flex;align-items: center;">
                            <label style="margin-top: 5px;">Discount:</label>
                            <input type="text" class="form-control @if($errors->has('discount_code')) is-invalid @endif"
                                   name="discount_code" style="max-width: 220px; margin-right: 10px; margin-left: 15px;"
                                   placeholder="Please enter discount code"
                                   value="{{ old('discount_code' , request()->get('discount_code')) }}">
                            <input type="submit" value="Apply" class="btn btn-outline-info">

                            @if($errors->any())
                                <div class="invalid-feedback ml-5" style="display: block">
                                    {{ implode('', $errors->all(':message')) }}
                                </div>
                            @endif
                            @if(isset($success))
                                <div class="invalid-feedback ml-5" style="display: block;color: #28a745;">
                                    {{ $success }}
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="row ">
                    @foreach($packages as $package)
                        <div class="col-md-4">
                            <form action="{{route('payment')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$package->id}}">
                                <div class=" text-center plans">
                                    <div class="subscription-box">
                                        <div class="same-line">
                                            <p class="name">{{$package->name}}</p>
                                            @if($package->id ==auth()->user()->package_id && isset($expire) && $expire >= Carbon::now()->toDateString())
                                                <div class="button-active"><span class="activate-plan">Activate</span>
                                                </div>
                                            @endif

                                        </div>
                                        @if(isset($discount))
                                            <input type="hidden" name="discount_id" value="{{$discount->id}}">
                                            <p class="kd-month" style="color: red;margin: 0;line-height: 15px;text-decoration-line: line-through;margin-top: 25px;">
                                                KD {{number_format($package->price, 2, '.', '')}} <!-- <span class="per-month">/per-month</span> -->
                                            </p>
                                            <p class="kd-month">
                                                KD {{number_format($discount->convertPrice($package->price), 2, '.', '')}} <!-- <span class="per-month">/per-month</span> -->
                                            </p>
                                        @else
                                            <p class="kd-month">
                                                KD {{number_format($package->price, 2, '.', '')}} <!-- <span class="per-month">/per-month</span> -->
                                            </p>
                                        @endif
                                        @if($package->id ==auth()->user()->package_id && isset($expire) && $expire >= Carbon::now()->toDateString())
                                            <p class="expiration">Expiration Date: {{$expire}}</p>
                                        @endif
                                        <p class="month-plan">{{$package->duration_title}}</p>
                                        @if(Carbon::now()->toDateString() > $expire)
                                            <div class="text-left">
                                                <button class="btn btn-success">BUY</button>
                                            </div>
                                        @endif
                                        @if($package->description)
                                            <p><a href="javascript:void(0)" class="view-more">View More</a></p>
                                            <div class="description" style="display: none;">
                                                <span>{{$package->description}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
            <script type="text/javascript">
                function planActivate(plan_id, obj) {
                    message = `You want to activate this plan as the currently activated plan will get deactivated ?`;
                    swal({
                        title: 'Are you sure?',
                        text: message,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0CC27E',
                        cancelButtonColor: '#FF586B',
                        confirmButtonText: 'Yes, Continue',
                        cancelButtonText: 'No, Cancel!',
                        confirmButtonClass: 'btn btn-success mr-5',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                    }).then(function () {
                        $.get('https://dev.dealsco.app/freelancer/active-plan/' + plan_id, function (data) {
                            alertMessage('success', 'Success!', data.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }).fail(function () {
                            alertMessage('error', 'Error!', 'Something went wrong.');
                        });
                    }, function (dismiss) {
                        // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                        if (dismiss === 'cancel') {
                            /*swal(
                                'Cancelled',
                                'Your imaginary file is safe :)',
                                'error'
                            )*/
                        }
                    });
                }

                function planDeactivate(plan_id, obj) {

                    swal({
                        title: 'Are you sure?',
                        text: "You want to deactivate this plan.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0CC27E',
                        cancelButtonColor: '#FF586B',
                        confirmButtonText: 'Yes, Continue',
                        cancelButtonText: 'No, Cancel!',
                        confirmButtonClass: 'btn btn-success mr-5',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                    }).then(function () {
                        $.get('https://dev.dealsco.app/freelancer/deactive-plan/' + plan_id, function (data) {
                            alertMessage('success', 'Success!', data.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }).fail(function () {
                            alertMessage('error', 'Error!', 'Something went wrong.');
                        });
                    }, function (dismiss) {
                        // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                        if (dismiss === 'cancel') {
                            /*swal(
                                'Cancelled',
                                'Your imaginary file is safe :)',
                                'error'
                            )*/
                        }
                    });
                }

                $('.view-more').click(function () {
                    $(this).closest('.subscription-box').find('.description').slideToggle();
                });
            </script>
        </div>
    </div>
@stop
