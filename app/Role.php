<?php

namespace App;

use App\Services\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasPermissions;

    protected $fillable=['name'];
}
