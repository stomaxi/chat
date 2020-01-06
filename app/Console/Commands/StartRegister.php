<?php

namespace App\Console\Commands;

use GatewayWorker\Register;
use Illuminate\Console\Command;
use Workerman\Worker;

class StartRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:start_reg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'start register';

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

        // register 服务必须是text协议
        $register = new Register('text://0.0.0.0:1236');


        Worker::runAll();
    }
}
