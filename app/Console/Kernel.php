<?php

namespace App\Console;

use App\Console\Commands\expiredWaitingList;
use App\Console\Commands\sendMessageNotification;
use App\Freelancer;
use App\Mail\SendGrid;
use App\Meeting;
use App\FreelancerWorkshop;
use App\OTP;
use App\PushDevices;
use App\Settings;
use App\UserNotification;
use App\FreelancerNotification;
use App\Console\Commands\clearUnpayService;
use App\Console\Commands\clearUnpayWorkshop;
use App\Console\Commands\completeService;
use App\TimeCalender;
use Carbon\Carbon;
use App\ServiceUserOrders;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        clearUnpayService::class,
        clearUnpayWorkshop::class,
        completeService::class,
        expiredWaitingList::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        $schedule->call(function () {
            TimeCalender::where('date', '<', Carbon::now()->subDays(10))->each(function ($item) {
                 $item->delete();
             });
        })->daily()->at('3:30');

        $schedule->call(function () {
            OTP::where('created_at', '<', Carbon::now()->subMinutes(15))->delete();
        })->everyFifteenMinutes();

        $schedule->call(function () {
            PushDevices::whereNull('token')->orwhere('token' , "")->delete();
            DB::delete ('DELETE c1 FROM `push_devices` c1
INNER JOIN push_devices c2 
WHERE
    c1.id > c2.id AND 
    c1.`user_id` = c2.user_id AND 
    c1.`user_type` = c2.user_type AND 
    c1.`token` = c2.token;');
        })->daily()->at('3:30');

        $schedule->call(function () {
            $from = Carbon::now()->addDay()->toDateString();
            $to = Carbon::now()->addDays(2)->toDateString();
            $meetings = Meeting::whereBetween('date', [$from, $to])->get();
            foreach ($meetings as $meeting) {
                FreelancerNotification::add($meeting->user_id,$meeting->freelancer_id,['reminder' , $meeting->user->Fullname , $meeting->date .' '.$meeting->time ],'reminder',['meeting_id' => $meeting->id]);
                UserNotification::add($meeting->user_id,$meeting->freelancer_id,['reminder' , $meeting->freelancer->name , $meeting->date .' '.$meeting->time ],'reminder',['meeting_id' => $meeting->id]);
            }
        })->daily()->at('04:00');

        $schedule->call(function () {
            $from = Carbon::now()->addDay()->toDateString();
            $to = Carbon::now()->addDays(2)->toDateString();
            $services = ServiceUserOrders::whereBetween('date', [$from, $to])->get();
            foreach ($services as $service) {
                FreelancerNotification::add($service->order->user_id,$service->freelancer_id,['reminder' , $service->order->user->Fullname , $service->date .' '.$service->time ],'reminder',['service_id' => $service->id]);
                UserNotification::add($service->order->user_id,$service->freelancer_id,['reminder' , $service->freelancer->name , $service->date .' '.$service->time ],'reminder',['service_id' => $service->id]);
            }
        })->daily()->at('04:30');

        $schedule->call(function () {
            $from = Carbon::now()->addDay()->toDateString();
            $to = Carbon::now()->addDays(2)->toDateString();
            $workshops = FreelancerWorkshop::whereBetween('date', [$from, $to])->get();
            foreach ($workshops as $workshop) {
                $users = $workshop->users;
                foreach ($users as $user) {
                    UserNotification::add($user->id,$workshop->freelancer_id,['reminder' , $workshop->freelancer->name , $workshop->date .' '.$workshop->from_time ],'reminder',['workshop_id' => $workshop->id]);
                }
            }
        })->daily()->at('05:00');

        $schedule->call(function () {
            $from = Carbon::now()->addDay()->toDateString();
            $to = Carbon::now()->addDays(2)->toDateString();
            $Freelancers = Freelancer::whereBetween('expiration_date', [$from, $to])->get();
            foreach ($Freelancers as $Freelancer) {
                FreelancerNotification::add(null,$Freelancer->id,['subscription'],'subscription');
            }
        })->daily()->at('05:30');

        $schedule->call(function () {
            $Freelancers = Freelancer::query()->whereDate('expiration_date', now()->addWeek())->get();
            $settings = Settings::where("keyname", "setting")->first();
            foreach ($Freelancers as $freelancer) {
                $data = [
                    'dear' => trans('webMessage.dear',[],'en') . ' ' . $freelancer->name,
                    'footer' => trans('webMessage.email_footer',[],'en'),
                    'message' => '<p>Reminder! your subscriptions with Deerha App is due in one week. If you would like to renew visit the website <a href="'.asset('').'">'.asset('').'</a>.</p>',
                    'subject' => 'Reminder! subscriptions with '.$settings->name_en.' App is due.' ,
                    'email_from' => env('MAIL_USERNAME' , $settings->from_email),
                    'email_from_name' => $settings->from_name
                ];
                \Illuminate\Support\Facades\Mail::to($freelancer->email)->send(new SendGrid($data));
            }
        })->daily()->at('06:00');
        
        $schedule->call(function () {
            $from = Carbon::now()->subMinutes(10);
            $to = Carbon::now();
            $Freelancers = Freelancer::query()->whereBetween('expiration_date', [$from, $to])->get();
            $settings = Settings::where("keyname", "setting")->first();
            foreach ($Freelancers as $freelancer) {
                $data = [
                    'dear' => trans('webMessage.dear',[],'en') . ' ' . $freelancer->name,
                    'footer' => trans('webMessage.email_footer',[],'en'),
                    'message' => '<p>Your Package has been expired. If you would like to renew visit the website <a href="'.asset('').'">'.asset('').'</a>.</p>',
                    'subject' => 'subscriptions with '.$settings->name_en.' App has been expired!' ,
                    'email_from' => env('MAIL_USERNAME' , $settings->from_email),
                    'email_from_name' => $settings->from_name
                ];
                \Illuminate\Support\Facades\Mail::to($freelancer->email)->send(new SendGrid($data));
            }
        })->everyTenMinutes();

        $schedule->call(new clearUnpayWorkshop())->everyThirtyMinutes();
        $schedule->call(new clearUnpayService())->everyThirtyMinutes();
        $schedule->call(new sendMessageNotification())->everyThirtyMinutes();
        $schedule->call(new completeService())->daily()->at('3:45');
        $schedule->call(new expiredWaitingList())->daily()->at('00:01');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        
        require base_path('routes/console.php');
    }
}
