<?php

namespace App\Console\Commands;

use App\UserWaiting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class expiredWaitingList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete:waitingList';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'complete all orders';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            UserWaiting::whereDate('date', '<=' , Carbon::yesterday())->delete();
        } catch (\Exception $e ){
            DB::rollBack();
        }
        DB::commit();
    }

    
    public function __invoke()
    {
        $this->handle();
    }
}
