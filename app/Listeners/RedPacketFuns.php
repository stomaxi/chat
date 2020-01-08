<?php

namespace App\Listeners;

use App\Events\RedPacketFun;
use App\Repositories\RedPacketRepository;
use App\Repositories\TaskRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class RedPacketFuns implements ShouldQueue
{
    public $connection = 'redis';
    public $queue = 'redCurl';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RedPacketFun  $event
     * @return void
     */
    public function handle(RedPacketFun $event)
    {
        $redOBJ = resolve(RedPacketRepository::class);
        $data =  $redOBJ->send($event->uid,$event->data);
        $mode = resolve(TaskRepository::class)->getOrderModel($event->data['order']);
        if ($data != 'success'){
            //未响应
            $type = $event->data['type'];
            if ($mode->func_data != $event->data['type']){
                //新类型
                $num = 1;
            }else{
                $num = $mode->func_num+1;
            }
            $time = $this->getNextFuncTime($num);

            if ($num >= config('share.red_packet.func_num')){
                $this->responseFail($mode);//响应失败
            }else{
                $this->setFun($mode, $type, $num, $time);//继续响应
            }
        }else{
            if ($mode->is_func == 1){
                //响应成功
                $this->responseSuccess($mode);
            }
        }
    }

    /**
     *
     * 保存下次回调信息
     *
     * */
    public function setFun($mode, $type, $num, $time, $is_func = 1)
    {
        $mode->func_data = $type;
        $mode->func_num = $num;
        $mode->next_func_time = $time;
        $mode->is_func = $is_func;
        $mode->save();
    }


    /**
     *
     * 响应成功
     * */
    public function responseSuccess($mode)
    {
        $mode->is_func = 0;
        $mode->save();
    }

    /**
     *
     * 响应失败
     * */
    public function responseFail($mode)
    {
        $mode->is_func = 2;
        $mode->save();
    }

    /**
     *
     * 获取下次通知时间
     *
     * @param  $num int 下次通知次数
     * @return int
     * */
    public function getNextFuncTime($num)
    {
        $sum = ($num*($num-1))/2;
        return time()+($sum*60);
    }
}
