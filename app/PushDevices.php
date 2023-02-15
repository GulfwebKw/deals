<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushDevices extends Model
{
    protected $table = "push_devices";
    protected $guarded = ['id'];

    public function user(){
        return $this->morphTo();
    }
}
