<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportMessage extends Model
{
    protected $table = "report_messages";
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

}
