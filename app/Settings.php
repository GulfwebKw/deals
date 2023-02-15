<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public $table = "gwc_settings";

    public static function get($key, $default = null)
    {
        if ($match = self::where('keyname', $key)->first()) {
            return $match;
        }

        return $default;
    }

    public static function getOne($field , $default = null , $key = "setting")
    {
        if ($match = self::where('keyname', $key)->first()) {
            return $match[$field] ?? $default;
        }

        return $default;
    }


    public static function getLocale($key, $default = 'ltr')
    {
        if($match = language::where('key', $key)->first()->dir) {
            return $match;
        }

        return $default;
    }
}