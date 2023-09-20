<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class Freelancer extends Authenticatable
{
    use HasApiTokens;
    protected $guarded = ['id'];

    protected $hidden = [
        'is_approved'
    ];

    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken' , 'user_id');
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }

    public function services()
    {
        return $this->hasMany(FreelancerServices::class, 'freelancer_id');
    }

    public function serviceOrder()
    {
        return $this->hasMany(ServiceUserOrders::class, 'freelancer_id');
    }


    public function mettings()
    {
        return $this->hasMany(Meeting::class, 'freelancer_id');
    }


    public function scopeRates($query, $data)
    {
        if ($data) {
            $query->whereHas('rate', function ($q) use ($data){
                $q->where('rate','>=', $data);
            });
        }
        return null;
    }

    public function scopeService($query, $data)
    {
        if ($data) {
            $query
                ->leftJoin('freelancer_services' , 'freelancers.id' ,'freelancer_services.freelancer_id')
                ->select('freelancers.*', DB::raw('IFNULL(AVG(freelancer_services.price),0) as AvgPrice'))
                ->orderBy('AvgPrice',$data)
                ->groupby('freelancers.id');
        }
        return null;
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class , 'category_freelancer');
    }

    public function workshops()
    {
        return $this->hasMany(FreelancerWorkshop::class, 'freelancer_id');
    }
    public function workshopsOrder()
    {
        return $this->hasMany(WorkshopOrder::class, 'freelancer_id');
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class, 'rate_id');
    }

    public function address()
    {
        return $this->hasMany(FreelancerAddress::class, 'freelancer_id');
    }

    public function quotations(){
        //return $this->hasMany(FreelancerQuotation::class, 'freelancer_id');
        return $this->hasMany(Quotation::class, 'freelancer_id');
    }
  

    public function wishlist()
    {
        return $this->belongsToMany(Freelancer::class, 'user_freelancer', 'freelancer_id', 'user_id');
    }

    public function wishlistExist()
    {
        return $this->wishlist()->where('user_id', Auth::id());

    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'freelancer_id');
    }
    
    public function calendar()
    {
        return $this->hasMany(TimeCalender::class, 'freelancer_id');
    }

    public function messages()
    {
        return $this->hasMany(FreelancerUserMessage::class, 'freelancer_id');
    }

    public function messagesUser()
    {
        return $this->messages()->with('user');
    }

    public function notificationToUser()
    {
        return $this->hasMany(UserNotification::class, 'freelancer_id');
    }

    public function notification()
    {
        return $this->hasMany(FreelancerNotification::class, 'freelancer_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function ReportUser()
    {
        return $this->hasMany(ReportMessage::class, 'freelancer_id');
    }


    public function blockedUser()
    {
        return $this->belongsToMany(User::class, 'blocked_user_freelancer', 'freelancer_id', 'user_id');
    }

    public function highlights(){
        return $this->hasMany(FreelancerHighlight::class , 'freelancer_id')->latest();
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class , 'freelancer_areas');
    }


    public function OTP(){
        return $this->morphOne(OTP::class, 'object');
    }

    public function pushNotification(){
        return $this->morphMany(PushDevices::class, 'user');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'freelancer_id');
    }
}
