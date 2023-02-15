<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attr_group extends Model
{
    protected $fillable = [
        'value', 'name'
    ];

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
