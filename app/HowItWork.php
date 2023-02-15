<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class HowItWork extends Model
{
    use translatable;
    public $translationModel = 'App\HowItWork_translation';
    public $translatedAttributes = ['title', 'description', 'sub_title'];
    protected $guarded = ['id'];

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
