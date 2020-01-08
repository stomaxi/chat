<?php

namespace App\Console\Commands;

use App\Repositories\TaskRepository;
use Illuminate\Console\Command;

class TaskFunc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:func';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '回调通知红包商户订单结果';

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
    public function handle(TaskRepository $taskRepository)
    {
        $data = $taskRepository->getNeedFunc();
        foreach ($data as $mode){
            $taskRepository->sendRedPackFunc($mode, $mode->func_data);
        }
    }


}
