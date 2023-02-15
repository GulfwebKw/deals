<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserQuotation extends Model
{
    protected $guarded =['id'];
    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
    
   public function getAttachmentAttribute($value)
    {
        if ($value)
        return '/uploads/quotation/'.$value;
        else
            return null;
    }
}
