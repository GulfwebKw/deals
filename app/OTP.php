<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $table = "otps";
    protected $guarded = ['id'];

    public function user(){
        return $this->morphTo('object');
    }
}
