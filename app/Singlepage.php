<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Singlepage extends Model
{
    public $table = "gwc_single_pages";


    public static function get($key, $default = null)
    {
        if ($match = self::where('name', $key)->first()) {
            return $match;
        }

        return $default;
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}