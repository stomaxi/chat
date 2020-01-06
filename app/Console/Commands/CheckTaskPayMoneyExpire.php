<?php

namespace App\Console\Commands;

use App\Repositories\TaskRepository;
use App\Storage\Database\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckTaskPayMoneyExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckTaskPayMoneyExpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定时检查商户过期支付红包任务';

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
        $obj = resolve(TaskRepository::class);
        $data = $obj->getExpirePayMoney();
        foreach ($data as $v){
            $this->handExpire($v,$obj);
        }
    }

    public function handExpire(Task $task, $obj)
    {
        $ret = $obj->setNoPayMoney($task);
        $this->info($ret);

    }
}
