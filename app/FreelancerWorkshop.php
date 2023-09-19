<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
class FreelancerWorkshop extends Eloquent
{
    use translatable;
    public $translationModel = 'App\FreelancerWorkshopTranslation';
    public $translatedAttributes = ['name', 'description'];

    protected $hidden = [
        'payment_id',
        'error',
        'result',
        'order_track',
        'is_delete',
    ];

    protected $casts = [
        'is_delete' => 'boolean',
    ];

    protected $guarded = ['id'];


    public static $cost = [
        30 => 10 , // 1 to 30 person : 10KD
        70 => 20 , // 31 to 70 person : 20KD
        100 => 30 , // 71 to 100 person : 30KD
        'more' => 40 // more than 100 : 40KD
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('isApproved', function (Builder $builder) {
            if (auth('api_freelancer')->check() ) {
                $builder->where(function($query) use ($builder) {
                    $query->where($builder->getModel()->qualifyColumn('is_approved'), 'approved')
                        ->orWhere('freelancer_id' , auth('api_freelancer')->id() );
                });
            } elseif ( ! auth('admin')->check() )
                $builder->where($builder->getModel()->qualifyColumn('is_approved'), 'approved');
        });
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function orders()
    {
        return $this->hasMany(WorkshopOrder::class,'workshop_id');
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }
    
    public function users(){
        return $this->belongsToMany(User::class, 'workshop_orders', 'workshop_id');
    }
}
