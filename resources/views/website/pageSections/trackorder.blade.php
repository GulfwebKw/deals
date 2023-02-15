<div class="login-register-area black-bg-5 pt-60 pb-65">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <div>
                                        <form method="post" action="{{ url('/trackorder') }}">
                                            @csrf
                                            <input type="text" name="trackid" placeholder="Order Track ID" required>

                                            <div class="clearfix"></div>
                                            <div class="button-box text-center">
                                                <button type="submit">
                                                    <span>Check Now</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($order)
@php
    if(!empty($order->country_id)){
        $country = \App\Country::find($order->country_id);
        $country = $country->title_en;
    }
    if(!empty($order->city_id)){
        $city = \App\City::find($order->city_id);
        $city = $city->title_en;
    }
@endphp
<div class="kt-portlet__body kt-portlet__body--fit">
    <div class="kt-invoice-1">
        <div class="kt-invoice__head" style="background-image: url({{asset('site_assets/img/bg/bg-14.jpg')}});background-size: 100% 500px;background-repeat: no-repeat;">
            <div class="kt-invoice__container" style="width:100%;">
                <div class="container-fluid p-4">
                    <div class="text-center">
                        <img src="{{ asset('/uploads/packages/' . $package->cover_image) }}" style="margin-bottom: 20px" />
                        <br>
                        <h3 style="color: white">{{ $package->title_en . '(' . $package->code . ')' }}</h3>
                        <br>
                        <p style="color: white">{{ $package->short_details_en }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-invoice__body">
            <div class="kt-invoice__container" style="width:100%;margin-top: 40px">
                <div class="container-fluid">
                    <div style="text-align: center;font-size: 18px;">
                        This Order Is <span style="font-size: 18px;color: #333333">{{ $order->order_status }}</span>!
                    </div>
                    <hr>
                    <div class="row p-4">
                        <div class="col-md-6" style="text-align: center;border-right: 1px solid black">
                            <h3>Order Details</h3><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Email</span> :
                            <span style="font-size: 18px;color: #333333">{{ $order->email }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Phone</span> :
                            <span style="font-size: 18px;color: #333333">{{ $order->country_code . '-' . $order->phone }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Mobile</span> :
                            <span style="font-size: 18px;color: #333333">{{ $order->mobile }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Country</span> :
                            <span style="font-size: 18px;color: #333333">{{ $country }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">City</span> :
                            <span style="font-size: 18px;color: #333333">{{ $city }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Block</span> :
                            <span style="font-size: 18px;color: #333333">{{ $order->block }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Street</span> :
                            <span style="font-size: 18px;color: #333333">{{ $order->street }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Avenue</span> :
                            <span style="font-size: 18px;color: #333333">{{ $order->avenue }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">House</span> :
                            <span style="font-size: 18px;color: #333333">{{ $order->house }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Flat</span> :
                            <span style="font-size: 18px;color: #333333">{{ $order->flat }}</span><br>

                        </div>
                        <div class="col-md-6" style="text-align: center;border-left: 1px solid black">
                            <h3>Transaction Details</h3><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Payment Id</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->paymentid }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Tran Id</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->tranid }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Auth</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->auth }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Ref</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->ref }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Post Date</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->postdate }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Avr</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->avr }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Amount</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->amount }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Status</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->payment_status }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Result</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->presult }}</span><br>

                            <span style="font-size: 18px;font-weight: bold;color: black">Track Id</span> :
                            <span style="font-size: 18px;color: #333333">{{ $transaction->trackid }}</span><br>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="kt-invoice__footer pb-2">
            <div class="kt-invoice__container" style="width:100%;">
                <div class="kt-invoice__bank" style="text-align: center;font-size: 20px;padding: 20px">
                        <span>
                            Invoice Generated For : {{ $order->fname . ' ' . $order->lname }}
                            At {{ date('Y-m-d H:m:s') }}
                            By {{ $settings->name_en }}
                            <br>
                            <button type="button" class="btn" onclick="window.print()">
                                <img src="{{ asset('/site_assets/img/icon-img/print.png') }}" />
                            </button>
                        </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif