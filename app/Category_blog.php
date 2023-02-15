<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Category_blog extends Eloquent
{
    use translatable;
    public $translationModel = 'App\Category_blog_translation';
    public $translatedAttributes = ['name', 'meta_desc'];
    protected $fillable = ['picture', 'parent_id', 'slug', 'meta_desc'];

    public function children()
    {
        return $this->hasMany(category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(category::class, 'parent_id');
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
        return Category_blog::where('slug', $slug)->first()->translate($locale)[$value];
    }
}
