<?php

namespace App\Console\Commands;

use App\UserOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class clearUnpayService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear un payed booked service!';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $serviceOrders = UserOrder::where('payment_status' , 'waiting')->get();
        foreach ($serviceOrders as $order){
            DB::beginTransaction();
            try {
                $services = $order->services()->get();
                foreach ($services as $service) {
                    $timeSlot = $service->timeSlot;
                    if ( $timeSlot != null ) {
                        $timeSlot->status = 'free';
                        $timeSlot->bookedable_id = null;
                        $timeSlot->bookedable_type = null;
                        $timeSlot->save();
                    }
                }
                $order->delete();
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
