<?php

namespace App\Listeners;

use App\Events\NotificationSavedEvent;
use App\Events\TimesCalendarSavedEvent;
use App\Http\Controllers\Common;
use App\Settings;
use App\UserNotification;
use App\UserWaiting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TimesCalendarSavedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TimesCalendarSavedEvent $timeslot)
    {
        $timeslot = $timeslot->time;
        if ( $timeslot->status != "free" )
            return;

        $waitingLists = UserWaiting::whereDate( 'date' , $timeslot->date)
            ->where('freelancer_id' , $timeslot->freelancer_id)
            ->get();
        foreach ( $waitingLists as $waitingList){
            UserNotification::add($waitingList->user_id,$waitingList->freelancer_id,['waitingList' , $waitingList->freelancer->name , $waitingList->date ],'waitingList',['service_id' => $waitingList->service_id]);
            $waitingList->delete();
        }
    }
}
