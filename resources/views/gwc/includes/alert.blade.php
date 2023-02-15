@if(Session::get('message-success'))
<div data-notify="container" class="alert m-alert animated fadeInDown alert-success" role="alert" data-notify-position="top-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1031; top: 20px; right: 20px;"><button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1033;"></button>
<span data-notify="icon"></span>
<span data-notify="title"></span>
<span data-notify="message">{{ Session::get('message-success') }}</span>
<a href="#" target="_blank" data-notify="url"></a>
</div>
@endif
@if(Session::get('message-error'))
<div data-notify="container" class="alert m-alert animated fadeInDown alert-danger" role="alert" data-notify-position="top-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1031; top: 20px; right: 20px;"><button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1033;"></button>
<span data-notify="icon"></span>
<span data-notify="title"></span>
<span data-notify="message">{{ Session::get('message-error') }}</span>
<a href="#" target="_blank" data-notify="url"></a>
</div>
@endif