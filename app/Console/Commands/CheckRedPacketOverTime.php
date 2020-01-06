<?php

namespace App\Console\Commands;

use App\Repositories\TaskRepository;
use Illuminate\Console\Command;

class CheckRedPacketOverTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckRedPacketOverTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检查红包任务过期重发';

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
    }
    public function handData($obj)
    {
        $w = array(
            'status' => 1,
            array('efffet_at','<', time())
        );
        $datas = $obj->storage()->where($w)->get();
        foreach ($datas as $v){
            if ($v->repeat_num == config('share.red_packet.repeat_num')){
                //通知 并且更改状态为过期
                $obj->storage()->setOverTime($v);
            }else{
                //从新发送红包通知+更改有效期+次数
                if ($v->efffet_at < time()-config('share.red_packet.repeat_time')){
                    $time = time();
                    $ret = $obj->storage()->resetRedPacket($v, $time);
                    if ($ret){
                        $user = $v->user;
                        $use_pay = $obj->getRedPay(json_decode($v->use_pay,true));
                        $content = array(
                            'type'=>'red_packet',
                            'from_user_name'=>$user->name,
                            'pic' => $user->pic,
                            'to_group_id'=>$user->groupchat,
                            "content"=> $v->num,
                            "pay" =>$use_pay,
                            "start_time"=>$time,
                            'end_time' => $time+config('share.red_packet.efffet_at'),
                            'red_packet_id' => $v->order,
                            'repeat_num' => $v->repeat_num +1
                        );
                        event(new SendTalk($content,1));//发送红包通知
                    }
                }

            }
        }
    }
}
