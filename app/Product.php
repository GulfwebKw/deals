<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    use translatable;
    public $translationModel = 'App\product_translation';
    public $translatedAttributes = ['title','desc', 'short_desc'];
    protected $fillable = [
        'title', 'price', 'discount', 'final_price', 'sku', 'status', 'count_existing'
    ];

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope('status', function (Builder $builder) {
//            $builder->where('status', 1);
//        });
//    }

    public function category(){
       return $this->belongsToMany(category::class);
    }

    public function filter(){
        return $this->belongsToMany(Filter::class);
    }

    public function attr(){
        return $this->belongsTo(Attr_group::class, 'attr_id')->withDefault();
    }

    public function lan()
    {
        return $this->hasMany(product_translation::class, 'product_id');
    }

    public function scopeSortby($query, $sort){
        if ($sort!=null){
        $orderby = explode('-', $sort);
      return $query->orderBy($orderby[0], $orderby[1]);

        }else{
      return $query->orderBy('created_at', 'desc');
        }
    }

    public function scopeRangeprice($query, $price){
        if ($price!=null){

        $range = explode(';', $price);
        return $query->where('final_price', '>=', $range[0])->where('final_price', '<=', $range[1]);
        } else{
          return $query;
        }
    }

    public function scopeHass($query, $slug){
      return $query->whereHas('category', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
    }

    public function scopeFilterQuality($query, $data){
        if ($data && count(json_decode($data))>0) {
            return $query->whereHas('filter', function ($q) use ($data) {
                $q->whereIn('filter_id', json_decode($data));
            });
        } else{
            return $query;
        }
    }



}
