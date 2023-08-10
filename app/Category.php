<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\App;

class Category extends Eloquent
{
    use translatable;
    public $translationModel = 'App\category_translation';
    public $translatedAttributes = ['title', 'meta_desc'];
    protected $guarded = ['id'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function freelancers()
    {
        return $this->belongsToMany(Freelancer::class, 'category_freelancer');
    }

    public function child()
    {
        return $this->hasOne(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function lan()
    {
        return $this->hasMany(category_translation::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany(product::class);
    }

    public static function Seo($slug, $value, $locale){
        return Category::where('slug', $slug)->first()->translate($locale)[$value];
    }

    public function getImageAttribute($value)
    {
        if ($value)
            return '/uploads/categories/' . $value;
        else
            return null;
    }
    public function getSecondImageAttribute($value)
    {
        if ($value)
            return '/uploads/categories/' . $value;
        else
            return null;
    }

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
