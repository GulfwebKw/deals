<?php

namespace App\Console\Commands;

use App\UserOrder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class completeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'complete all orders';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $serviceOrders = UserOrder::whereIn('payment_status' , ['paid'] )->get();
        foreach ($serviceOrders as $order){
            DB::beginTransaction();
            try {
                $services = $order->services()
                    ->where('date', Carbon::yesterday())
                    ->whereIn('status', ['booked' , 'freelancer_reschedule' , 'user_reschedule' ,'admin_reschedule'] )
                    ->get();
                foreach ($services as $service) {
                    $service->status = 'completed';
                    $service->save();
                }
            } catch (\Exception $e ){
                DB::rollBack();
            }
            DB::commit();
        }
    }
    
    
    public function __invoke()
    {
        $this->handle();
    }
}
