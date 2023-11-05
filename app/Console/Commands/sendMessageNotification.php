<?php

namespace App\Console\Commands;

use App\Freelancer;
use App\FreelancerUserMessage;
use App\Http\Controllers\Common;
use App\Settings;
use App\User;
use App\UserNotification;
use App\UserOrder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class sendMessageNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notify unread message';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('start sending message notification' , []);
        $settingInfo = Settings::where("keyname", "setting")->first();
        $users = FreelancerUserMessage::query()
            ->selectRaw('count(id) as sum, user_id')
            ->where('type' , 'freelancer' )
            ->where('isPushSend' , 0 )
            ->where('userRead' , 0 )
            ->where('created_at' , '>=' , \Illuminate\Support\Carbon::now()->subMinutes(30))
            ->groupBy(['user_id'])
            ->get();
        Log::info('start sending message notification' , $users->toArray());
        foreach ($users as $userM){
            $user = User::find($userM->user_id);

            FreelancerUserMessage::query()
                ->where('type' , 'freelancer' )
                ->where('isPushSend' , 0 )
                ->where('userRead' , 0 )
                ->where('user_id' , $userM->user_id )
                ->where('created_at' , '>=' , \Illuminate\Support\Carbon::now()->subMinutes(30))
                ->update(['isPushSend' => 1] );
            if ( ! $user or ! $user->recive_notification )
                continue;
            $OTPS = $user->pushNotification()->get();
            $OTPTokens = $OTPS->pluck('token')->unique();
            foreach ( $OTPTokens as $OTPToken)
                Common::sendMobilePush(true , $settingInfo,$OTPToken, websiteName(), 'You have '.number_format($userM->sum).' unread messages.' );

        }
        $users = FreelancerUserMessage::query()
            ->selectRaw('count(id) as sum, freelancer_id')
            ->where('type' , 'user' )
            ->where('isPushSend' , 0 )
            ->where('freelancerRead' , 0 )
            ->where('created_at' , '>=' , \Illuminate\Support\Carbon::now()->subMinutes(30))
            ->groupBy(['freelancer_id'])
            ->get();
        Log::info('start sending message notification' , $users->toArray());
        foreach ($users as $userM){
            $user = Freelancer::find($userM->freelancer_id);
            if ( ! $user or ! $user->recive_notification )
                continue;
            $OTPS = $user->pushNotification()->get();
            $OTPTokens = $OTPS->pluck('token')->unique();

            FreelancerUserMessage::query()
                ->where('type' , 'user' )
                ->where('isPushSend' , 0 )
                ->where('freelancerRead' , 0 )
                ->where('freelancer_id' , $userM->freelancer_id )
                ->where('created_at' , '>=' , \Illuminate\Support\Carbon::now()->subMinutes(30))
                ->update(['isPushSend' => 1] );
            
            foreach ( $OTPTokens as $OTPToken)
                Common::sendMobilePush(false , $settingInfo,$OTPToken, websiteName(), 'You have '.number_format($userM->sum).' unread messages.' );

        }
        Log::info('finish sending' , []);
    }
    
    
    public function __invoke()
    {
        $this->handle();
    }
}
