<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerQuotation extends Model
{
    protected $guarded = ['id'];
    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
