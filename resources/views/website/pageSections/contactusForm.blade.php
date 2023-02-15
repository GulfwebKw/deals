<div class="col-md-8">
    <h2>{{ __('site.send_us_your_comments_or_questions') }}</h2>

    <form class="white-row" name="contactformfrm" id="contactformfrm" action="contactform" method="post">
        @csrf

        <div class="row">
            @if(Session::get('session_msg'))
                <div id="messagesuccess" class="col-md-12"
                     style="font-size: 16px;background-color: green;color: white;border-radius: 10px;padding: 10px;text-align: center;margin-bottom: 30px;">
                    {{ Session::get('session_msg') }}
                </div>
            @endif
        </div>

        <div class="row">
            <div class="form-group">

                <div class="col-md-6">
                    <label style="font-family: 'Open Sans',Arial,sans-serif;font-size: 14px;color: #7e8998;">{{ __('site.full_name') }} *</label>
                    <input type="text" maxlength="100" class="form-control" name="name" id="name" required
                           data-error="{{ __('site.enter_name') }}" value="{{ old('name') }}">
                    <div class="help-block with-errors">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label style="font-family: 'Open Sans',Arial,sans-serif;font-size: 14px;color: #7e8998;">{{ __('site.email') }} *</label>
                    <input type="email" maxlength="100" class="form-control" name="email" id="email" required
                           data-error="{{ __('site.enter_email') }}" value="{{ old('email') }}">
                    <div class="help-block with-errors">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label style="font-family: 'Open Sans',Arial,sans-serif;font-size: 14px;color: #7e8998;">{{ __('site.subject') }} *</label>
                    <select name="subject" class="form-control">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">
                                {{ $subject->{'title_'.$lang} }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label style="font-family: 'Open Sans',Arial,sans-serif;font-size: 14px;color: #7e8998;">{{ __('site.message') }} *</label>
                    <textarea maxlength="5000" rows="10" class="form-control" name="message" id="message" required
                              data-error="{{ __('site.write_message') }}">{{ old('message') }}</textarea>
                    <div class="help-block with-errors">
                        @error('message')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="form-group col-md-6" style="text-align: center">
                                <div class="captcha">
                                    <span class="mx-2">{!! captcha_img('flat') !!}</span>
                                    <button type="button" id="refreshCaptch" class="btn btn-success">{{__('site.refresh')}}</i></button>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <input id="refresh" type="text" class="form-control" placeholder="{{__('site.enter_captcha')}}" name="captcha" required>
                                @error('captcha')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12" style="text-align: center">
                <input type="submit" value="{{ __('site.send_message') }}" class="btn btn-primary btn-lg submitBtn" data-loading-text="Loading...">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 margin-top10">
                <span id="formResponse"></span>
            </div>
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