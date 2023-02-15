<div class="login-register-area black-bg-5 pt-60 pb-65">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <h4 style="color:#fff;"> SUBSCRIBE </h4>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">

                                    <form method="post" action="{{ url('/pay') }}">
                                        @csrf
                                        <input type="hidden" name="code" value="{{ $code }}">

                                        <label>First Name</label>
                                        <input type="text" name="firstname" placeholder="First Name" required>

                                        <label>Last Name</label>
                                        <input type="text" name="lastname" placeholder="Last Name" required>

                                        <label>Email Address</label>
                                        <input type="email" name="email" placeholder="Email Address" required>

                                        <label>Telephone</label>
                                        <div>
                                            <input type="text" name="countrycode" placeholder="Country Code" required style="width: 30%">
                                            <input type="text" name="phone" placeholder="Telephone" required style="width: 69%">
                                        </div>

                                        <label>Mobile Number</label>
                                        <input type="text" name="mobile" placeholder="Mobile Number" required>

                                        <label>Country</label>
                                        <div>
                                            <select name="country" id="country-list" onChange="getCities(this.value);" required
                                                    style="background-color: #fff;border: 1px solid #ebebeb;color: #666;font-size: 14px;height: 50px;margin-bottom: 30px;padding: 0 15px;">
                                                <option value="" disabled selected>Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}" >
                                                        {{$country->title_en}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <label>City</label>
                                        <div>
                                            <select name="city" id="city-list" required disabled
                                                    style="background-color: #fff;border: 1px solid #ebebeb;color: #666;font-size: 14px;height: 50px;margin-bottom: 30px;padding: 0 15px;">
                                                <option value="" disabled>Select City</option>
                                            </select>
                                        </div>

                                        <label>Address</label>
                                        <div>
                                            <input type="text" name="block" placeholder="Block" required style="width: 33%">
                                            <input type="text" name="street" placeholder="Street" required style="width: 32%">
                                            <input type="text" name="avenue" placeholder="Avenue" required style="width: 33%">
                                        </div>

                                        <div>
                                            <input type="text" name="house" placeholder="House" required style="width: 50%">
                                            <input type="text" name="flat" placeholder="Flat" required style="width: 49%">
                                        </div>

{{--                                        <div class="ship-wrapper">--}}
{{--                                            <div class="single-ship">--}}
{{--                                                <input type="radio" name="paytype" value="knet" checked="">--}}
{{--                                                <label>Pay by Knet</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="single-ship">--}}
{{--                                                <input type="radio" name="paytype" value="credit">--}}
{{--                                                <label>Pay by Credit Card</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="single-ship">--}}
{{--                                                <input type="radio" name="paytype" value="paypal">--}}
{{--                                                <label>Pay by Paypal</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="clearfix"></div>
                                        <div class="button-box text-center">
                                            <button type="submit">
                                                <span>Pay Now</span>
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

<script>
    function getCities(val) {
        $.ajax({
            type: "POST",
            url: "/get-country-cities",
            data:'country_id='+val,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $("#city-list").addClass("loader");
            },
            success: function(data){
                $("#city-list").html(data);
                $("#city-list").prop('disabled', false);
                $("#city-list").removeClass("loader");
            }
        });
    }
</script>