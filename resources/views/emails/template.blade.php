<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
@php
    $settingInfo = App\Http\Controllers\WebController::settings();
@endphp
<div style="margin:5%;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td height="100" align="center" style="border-bottom:1px #CCCCCC solid;">@if($settingInfo->email_logo)<img
                        src="{{url('uploads/settings/'.$settingInfo->email_logo)}}" style="max-height:100px;"
                        alt="{{$settingInfo->name_en}}"/>@endif</td>
        </tr>
        <tr>
            <td style="padding:20px; font-family: arial, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'; color: #000; text-align: justify; font-size: 14px; line-height:23px;">
                <p>{!! $dear !!}</p>
                <p>{!! $email_body !!}</p>

            </td>
        </tr>
        <tr>
            <td><p>{!! $email_footer !!}</p></td>
        </tr>
        <tr>
            <td height="50" align="center" style="font-family: arial, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'; color:#000; font-size: 14px;border-top:1px #CCCCCC solid;">
              {!! __('webMessage.copyright1') !!}
              {{ $settingInfo->name_en }}
              {!! __('webMessage.copyright2') !!}
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>