<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
