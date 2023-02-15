<div class="login-register-area black-bg-5 pt-60 pb-65">
    <div class="container">

        <div class="row">
            @if(Session::get('session_msg'))
                <div id="messagesuccess" class="col-md-12"
                     style="font-size: 16px;background-color: green;color: white;border-radius: 10px;padding: 10px;text-align: center;margin-bottom: 30px;">
                    {{ Session::get('session_msg') }}
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <h4 style="color:#fff;"> CONTACT US </h4>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">

                                    <form method="post" action="{{ url('/contactsubmit') }}">
                                        @csrf

                                        <label>Name</label>
                                        <input type="text" name="name" placeholder="Name" required>

                                        <label>Mobile</label>
                                        <input type="text" name="mobile" placeholder="Mobile" required>

                                        <label>Email Address</label>
                                        <input type="email" name="email" placeholder="Email Address" required>

                                        <label>Subject</label>
                                        <div>
                                            <select name="subject" id="subject" required style="background-color: #fff;border: 1px solid #ebebeb;color: #666;font-size: 14px;height: 50px;margin-bottom: 30px;padding: 0 15px;">
                                                @foreach($subjects as $subject)
                                                    <option value="{{$subject->id}}" >
                                                        {{$subject->title_en}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <label>Message</label>
                                        <textarea name="message" rows="5" placeholder="Type Your Message Here ..." style="background-color: white"></textarea>

                                        <div class="row mt-4">
                                            <div class="form-group col-md-7" style="text-align: center">
                                                <div class="captcha">
                                                    <span class="">{!! captcha_img('flat') !!}</span>
                                                    <button type="button" id="refreshCaptch" class="btn btn-success" style="height: 45px;border-radius: 5px">{{__('site.refresh')}}</i></button>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-5">
                                                <input id="refresh" type="text" class="form-control" placeholder="{{__('site.enter_captcha')}}" name="captcha" required>
                                                @error('captcha')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="button-box text-center">
                                            <button type="submit">
                                                <span>Send</span>
                                            </button>
                                        </div>

                                        <script>
                                            $(function () {
                                                $('#refreshCaptch').click(function () {
                                                    console.log("button clicked");
                                                    $.ajax({
                                                        type: 'GET',
                                                        url: 'refreshcaptcha',
                                                        success: function (data) {
                                                            $(".captcha span").html(data.captcha);
                                                        }
                                                    });
                                                });
                                            });

                                            $.ajaxSetup({
                                                type : "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });
                                        </script>

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