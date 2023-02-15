<?php

namespace App\Console\Commands;

use App\WorkshopOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class clearUnpayWorkshop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:workshop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear un payed booked workshop!';



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $workshopOrders = WorkshopOrder::where('payment_status' , 'waiting')->get();
        foreach ($workshopOrders as $order){
             DB::beginTransaction();
             try {
                 $workshop = $order->workshop;
                 $workshop->reserved = $workshop->reserved - $order->people_count;
                 $workshop->available = intval($workshop->total_persons) - $order->reserved;
                 $workshop->save();
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
