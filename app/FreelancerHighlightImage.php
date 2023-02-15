<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreelancerHighlightImage extends Model
{
    public $timestamps = false;
    public $fillable = ['image'];
    public function highlight(){
        return $this->belongsTo(FreelancerHighlight::class );
    }
}
