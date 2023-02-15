<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category_translation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'meta_desc'];
}
