<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class blog_translations extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'short_desc', 'desc'];
}
