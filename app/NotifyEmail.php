<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class NotifyEmail extends Model
{
    use Notifiable;

	public $table = "gwc_notify_emails";

}
