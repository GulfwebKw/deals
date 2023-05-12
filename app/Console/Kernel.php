<?php

namespace App\Console;

use App\Console\Commands\expiredWaitingList;
use App\Freelancer;
use App\Meeting;
use App\FreelancerWorkshop;
use App\OTP;
use App\PushDevices;
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

        $schedule->call(new clearUnpayWorkshop())->everyThirtyMinutes();
        $schedule->call(new clearUnpayService())->everyThirtyMinutes();
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
