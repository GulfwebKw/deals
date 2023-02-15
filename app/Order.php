<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function freelancer(){
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }

    public function package(){
        return $this->belongsTo(Package::class);
    }

    public static function GetOrderStatus($number){
        return order::query()->where('status', $number)->get()->count();
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
