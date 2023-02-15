<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerHighlight extends Model
{
    protected $guarded = ['id'];

    public function images(){
        return $this->hasMany(FreelancerHighlightImage::class , 'highlight_id');
    }

    public function freelancer(){
        return $this->belongsTo(Freelancer::class );
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
