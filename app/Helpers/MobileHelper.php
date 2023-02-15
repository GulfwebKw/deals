<?php

namespace App\Helpers;
class MobileHelper
{
    public static function checkNumber($mobile)
    {
        if (preg_match("/^09[0-9]{9}$/", $mobile)) {
            return true;
        } else {
            return false;
        }
    }
}
