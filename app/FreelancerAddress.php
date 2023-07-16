<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreelancerAddress extends Model
{
    use SoftDeletes;
    protected $guarded = [
        'id'
    ];
    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }
    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
