<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationService extends Model
{
    protected $table = "quotations_service";
    protected $guarded = ['id'];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
