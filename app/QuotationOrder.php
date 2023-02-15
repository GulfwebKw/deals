<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationOrder extends Model
{
    public function quotation()
    {
        return $this->belongsTo(FreelancerQuotation::class, 'quotation_id')->with('freelancer', 'user');
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
