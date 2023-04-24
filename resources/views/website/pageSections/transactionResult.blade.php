<div class="login-register-area pt-60 pb-65">
    <div class="container">
        <div class="row1">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <h4 style="color:#ffb731;"> PAYMENT DETAILS </h4>
                    </div>
                    <div class="tab-content">
                        <p class="text-center">
                            @if($order->result == 'CAPTURED')
                                <img src="{{ asset('site_assets/img/checked.svg') }}" alt="" style="width:150px; height:auto; margin:30px 0 30px 0;">
                            @else
                                <img src="{{ asset('site_assets/img/fail.svg') }}" alt="" style="width:150px; height:auto; margin:30px 0 30px 0;">
                            @endif
                        </p>
                        <h1 class="text-center text-yellow" style="font-size:50px; font-weight:400;">
                            @if($order->result == 'CAPTURED')
                                Thank You
                            @else
                                Sorry
                            @endif
                        </h1>
                        <br/>
                        <p class="text-center white_text">

                            <label class="text-yellow">Date :</label> {{ date('Y-m-d') }}
                            <br/>

                            <label class="text-yellow">Transaction Status :</label>
                            @if($order->result == 'CAPTURED')
                                <font style="color:#57cc24;">
                                    Successful
                                </font>
                            @else
                                <font style="color:#f80909;">
                                    Failed
                                    <br>
                                    {{ $order->error }}
                                </font>
                            @endif
                            <br/>

                            <label class="text-yellow">Trasaction Track Id :</label>
                            {{ $order->order_track }}
                            <br/>

                            <label class="text-yellow">Payment Method :</label> Knet
                            <br/>

                            <label class="text-yellow">Amount :</label>
                            <font style="color:#df2121;">
                                KD {{ $order->amount }}
                            </font>

                        </p>
                    </div>
                </div>
            <div>
                {{--<a href="{{route('packages')}}" class="btn btn-primary">Go To Packages</a>--}}
            </div>
            </div>
        </div>
    </div>
</div>