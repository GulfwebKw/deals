<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    public function getImageAttribute($value)
    {
        if ($value)
        return '/uploads/slideshows/'.$value;
        else
         return null;
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
    
   
}
