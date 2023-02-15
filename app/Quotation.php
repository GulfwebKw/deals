<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = "quotations";
    protected $guarded = ['id'];
    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function freelancerAddress()
    {
        return $this->belongsTo(FreelancerAddress::class , 'address_id');
    }

    public function services()
    {
        return $this->hasMany(QuotationService::class , 'quotation_id');
    }

    public function installments()
    {
        return $this->hasMany(QuotationInstallment::class , 'quotation_id');
    }

}
