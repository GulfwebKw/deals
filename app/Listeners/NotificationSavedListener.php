<?php

namespace App\Listeners;

use App\Events\NotificationSavedEvent;
use App\Http\Controllers\Common;
use App\Settings;
use App\UserNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationSavedListener
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
    public function handle(NotificationSavedEvent $event)
    {
        $notification = $event->notification;
        $isUser = false;
        if ( $notification instanceof UserNotification) {
            $user = $notification->user;
            $isUser = true ;
        } else
            $user = $notification->freelancer ;

        if (! $user->recive_notification )
            return;

        $settingInfo = Settings::where("keyname", "setting")->first();

        $OTPS = $user->pushNotification()->get();
        $OTPTokens = $OTPS->pluck('token')->unique();
        foreach ( $OTPTokens as $OTPToken)
            Common::sendMobilePush($isUser , $settingInfo,$OTPToken, 'Deals', $notification->description_en );
    }
}
