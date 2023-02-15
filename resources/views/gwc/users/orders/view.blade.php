@extends('gwc.template.viewTemplate')

@section('viewContent')

    @if($order)
    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-invoice-1">
            <div class="kt-invoice__head" style="background-image: url({{asset('site_assets/img/bg/bg-14.jpg')}});background-size: 100% 500px;background-repeat: no-repeat;">
                <div class="kt-invoice__container" style="width:100%;">
                    <div class="container-fluid p-4">
                        <div class="text-center">
                            <h3 style="color: white">{{ $order->package->name }}</h3>
                            <br>
                            <p style="color: white">{{ $order->package->duration_title . '   ' . $order->package->duration . ' days' }}</p>
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
                            <div class="col-md-12" style="text-align: center;">
                                <h3>Order Details</h3><br>

                            <div class="col-md-12" style="text-align: center">
                                <span style="font-size: 18px;font-weight: bold;color: black">Payment Id</span> :
                                <span style="font-size: 18px;color: #333333">{{ $order->payment_id }}</span><br>

                                <span style="font-size: 18px;font-weight: bold;color: black">Amount</span> :
                                <span style="font-size: 18px;color: #333333">{{ $order->amount }}</span><br>

                                <span style="font-size: 18px;font-weight: bold;color: black">Status</span> :
                                <span style="font-size: 18px;color: #333333">{{ $order->payment_status }}</span><br>

                                <span style="font-size: 18px;font-weight: bold;color: black">Result</span> :
                                <span style="font-size: 18px;color: #333333">{{ $order->result }}</span><br>

                                <span style="font-size: 18px;font-weight: bold;color: black">Track Id</span> :
                                <span style="font-size: 18px;color: #333333">{{ $order->order_track }}</span><br>
                            </div>
                        </div>
                </div>
            </div>
            <hr>
            <div class="kt-invoice__footer">
                <div class="kt-invoice__container" style="width:100%;">
                    <div class="kt-invoice__bank" style="text-align: center;font-size: 20px;padding: 20px">
                        <span>
                            Invoice Generated For : {{ $order->freelancer->name }}
                            <button type="button" class="btn" onclick="window.print()">
                                <i class="kt-nav__link-icon flaticon2-print"></i>
                                <span class="kt-nav__link-text">{{__('adminMessage.print')}}</span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection