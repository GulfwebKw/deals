<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use translatable;
    public $translationModel = 'App\shipping_translation';
    public $translatedAttributes = ['desc'];
    protected $fillable = ['price', 'name', 'icon', 'desc'];
}
