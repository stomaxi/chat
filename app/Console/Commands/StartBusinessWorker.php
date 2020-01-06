<?php

namespace App\Console\Commands;

use GatewayWorker\BusinessWorker;
use Illuminate\Console\Command;
use Workerman\Worker;

class StartBusinessWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:start_bw';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'start BusinessWorker';

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
        // bussinessWorker 进程

        $worker = new BusinessWorker();
// worker名称
        $worker->name = 'ChatBusinessWorker';
// bussinessWorker进程数量
        $worker->count = 4;
// 服务注册地址
        $worker->registerAddress = '127.0.0.1:1236';


        Worker::runAll();

    }
}
