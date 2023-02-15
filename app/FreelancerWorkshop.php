<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;
class FreelancerWorkshop extends Eloquent
{
    use translatable;
    public $translationModel = 'App\FreelancerWorkshopTranslation';
    public $translatedAttributes = ['name', 'description'];
    protected $guarded = ['id'];

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
