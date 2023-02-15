<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="{{ asset('/uploads/settings/'.$settings['favicon']) }}">
<title>{{__('adminMessage.websiteName')}} | {{ $data['headTitle'] }}</title>

<!--css files -->
@include('gwc.css.user')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
      integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin=""/>
<!-- token -->
<meta name="csrf-token" content="{{ csrf_token() }}">