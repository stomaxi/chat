<?php

namespace App\Console\Commands;

use App\Events\TransactionOrderCancel;
use App\Repositories\TransactionOrderRepository;
use Illuminate\Console\Command;

class CheckTranasctionBuyExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkTranasctionBuyExpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检查用户购买挂单过期';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $obj = resolve(TransactionOrderRepository::class);
        $data = $obj->getExpire();
        foreach ($data as $v){
            event(new TransactionOrderCancel($v, $obj->storage(),2));
        }
    }
}
