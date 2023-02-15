<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerWorkshopTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
