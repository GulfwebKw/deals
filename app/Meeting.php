<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function slot()
    {
        return $this->belongsTo(TimeCalender::class, 'time_piece_id');
    }


    public function location()
    {
        return $this->belongsTo(FreelancerAddress::class, 'location_id');
    }
    public function userLocation()
    {
        return $this->belongsTo(Address::class, 'area_id');
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
