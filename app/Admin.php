<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
	use Notifiable;
	use HasRoles, HasApiTokens;


	protected $gaurd_name = "admin";
	
	public $table = "gwc_admins";


    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }
}
