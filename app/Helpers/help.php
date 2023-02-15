<?php


function getSetting($key)
{
    return App\Settings::get($key);

}

function getSingle($key)
{
    return App\Singlepage::get($key);

}


function GetPic($id)
{

    return App\product::GetPic($id);

}

function GetOrderStatus($number)
{

    return App\order::GetOrderStatus($number);

}

function getSettingId($key)
{
    return \App\Setting::getId($key);
}
function numberTranslate($str) {
    $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    return str_replace($arabic_western, $arabic_eastern, $str);
}

function make_slug($string) {
    return preg_replace('/\s+/u','-',trim($string));
}


function user($key){
   return Illuminate\Support\Facades\Auth::guard('web')->user()->$key;
}

function getLocale($en) {
    return \App\Settings::getLocale($en);

}