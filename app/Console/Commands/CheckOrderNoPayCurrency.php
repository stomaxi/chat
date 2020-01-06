<?php

namespace App\Console\Commands;

use App\Repositories\TransactionOrderRepository;
use Illuminate\Console\Command;

class CheckOrderNoPayCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkOrderNoPayCurrency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检查订单超时未付币';

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
        $data = $obj->getNoPayCurrency();
        foreach ($data as $v){
            $obj->setNoPayCurrencys($v);
        }

    }
}
