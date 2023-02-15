<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
class blog extends Eloquent
{
    use translatable;
    public $translationModel = 'App\blog_translations';
    public $translatedAttributes = ['title', 'short_desc', 'desc'];
    protected $fillable= [
        'title', 'short_desc', 'desc', 'image', 'status', 'slug', 'popular'
    ];

    public function comment(){
        return $this->hasMany(comment::class)->with('user');
    }

    public function category_blog(){
        return $this->belongsToMany(Category_blog::class, 'blog_categories', 'blog_id', 'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
