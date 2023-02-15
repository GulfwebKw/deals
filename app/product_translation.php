<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_translation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'desc', 'short_desc'];

}
