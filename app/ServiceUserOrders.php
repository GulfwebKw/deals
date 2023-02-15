<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceUserOrders extends Model
{
    protected $table = 'service_user_orders';

    protected $guarded = [ 'id' ];

    public function order()
    {
        return $this->belongsTo(UserOrder::class);
    }

    public function service()
    {
        return $this->belongsTo(FreelancerServices::class , 'service_id');
    }

    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }

    public function timeSlot()
    {
        return $this->morphOne(TimeCalender::class, 'bookedable');
    }
    
    public function freelancer_location(){
        return $this->belongsTo(FreelancerAddress::class , 'freelancer_location_id');
        
    }
    
    public function user_location(){
        return $this->belongsTo(Address::class , 'user_location_id');
        
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
