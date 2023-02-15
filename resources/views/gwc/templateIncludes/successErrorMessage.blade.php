@if(Session::get('message-success'))
    <div class="alert alert-light alert-success" role="alert">
        <div class="alert-icon">
            <i class="flaticon-alert kt-font-brand"></i>
        </div>
        <div class="alert-text">
            {{ Session::get('message-success') }}
        </div>
    </div>
@endif

@if(Session::get('message-error'))
    <div class="alert alert-light alert-danger" role="alert">
        <div class="alert-icon">
            <i class="flaticon-alert kt-font-brand"></i>
        </div>
        <div class="alert-text">
            {{ Session::get('message-error') }}
        </div>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-light alert-danger" role="alert">
        <div class="alert-icon">
            <i class="flaticon-alert kt-font-brand"></i>
        </div>
        <div class="alert-text">
            {!!  implode('', $errors->all('<div>:message</div>')) !!}
        </div>
    </div>
@endif