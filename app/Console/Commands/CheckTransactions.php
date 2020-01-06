<?php

namespace App\Console\Commands;

use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkTransactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检查过期挂单';

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
        $obj = resolve(TransactionRepository::class);
        $data = $obj->getExpire();
        $accOBJ = resolve(AccountRepository::class);
        try{
            foreach ($data as $v){
//                $ret = $obj->setExpire($v->id);
//                if (!$ret){
//                    DB::rollBack();
//                }
//                $flow = $accOBJ->addFlow($v->uid, $v->surplus);
//                if ($flow){
//                    DB::commit();
//                    $this->info('ok');
//                }else{
//                    DB::rollBack();
//                    $this->info('fail');
//                }
               $ret = $obj->setOrderExpire($v,$v->uid);
               $this->info($ret);


            }
        }catch (\Exception $exception){
            $this->info('fail');
        }
    }
}
