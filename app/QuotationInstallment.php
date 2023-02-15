<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationInstallment extends Model
{
    protected $table = "quotations_installment";
    protected $guarded = ['id'];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
