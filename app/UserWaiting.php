<?php

namespace App;

use App\Events\NotificationSavedEvent;
use Illuminate\Database\Eloquent\Model;

class UserWaiting extends Model
{
    protected $table = 'user_waiting';
    protected $guarded = ['id'];
    protected $dates = ['date'];
    public $timestamps = false;

    protected $dispatchesEvents = [
        'saved' => NotificationSavedEvent::class
    ];

    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function service(){
        return $this->belongsTo(FreelancerServices::class);
    }


    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
    
}
