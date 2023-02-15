<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullnameAttribute(){
        return $this->first_name . ' '. $this->last_name;
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function wishlist()
    {
        return $this->belongsToMany(Freelancer::class, 'user_freelancer', 'user_id', 'freelancer_id');
    }

    public function wishlistFreelancer()
    {
        return $this->wishlist()->with('freelancer');
    }

    public function quotations()
    {
        return $this->hasMany(UserQuotation::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(FreelancerUserMessage::class, 'user_id');
    }

    public function messagesFreelancer()
    {
        return $this->messages()->with('freelancer');
    }

    public function mettings()
    {
        return $this->hasMany(Meeting::class, 'user_id');
    }

    public function serviceOrder()
    {
        return $this->hasMany(UserOrder::class, 'user_id');
    }

    public function workshops()
    {
        return $this->hasMany(WorkshopOrder::class, 'user_id');
    }
    
    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }

    public function notification()
    {
        return $this->hasMany(UserNotification::class, 'user_id');
    }


    public function notificationToFreelancer()
    {
        return $this->hasMany(FreelancerNotification::class, 'user_id');
    }


    public function bills()
    {
        return $this->hasMany(Bill::class, 'user_id');
    }

    public function waiting()
    {
        return $this->hasMany(UserWaiting::class, 'user_id');
    }


    public function blockedFreelancer()
    {
        return $this->belongsToMany(Freelancer::class, 'blocked_user_freelancer', 'user_id', 'freelancer_id');
    }


    public function ReportFreelancer()
    {
        return $this->hasMany(ReportMessage::class, 'user_id');
    }

    public function OTP(){
        return $this->morphOne(OTP::class, 'object');
    }

    public function pushNotification(){
        return $this->morphMany(PushDevices::class, 'user');
    }


    public function blockedUser()
    {
        return $this->belongsToMany(Freelancer::class, 'blocked_user_freelancer', 'user_id', 'freelancer_id');
    }

    public function ReportUser()
    {
        return $this->hasMany(ReportMessage::class, 'user_id');
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
