<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkshopOrder extends Model
{
    
        protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function workshop()
    {
        return $this->belongsTo(FreelancerWorkshop::class, 'workshop_id');
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
