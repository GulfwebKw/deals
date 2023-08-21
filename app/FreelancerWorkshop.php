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
    protected $guarded = ['id'];
    

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
