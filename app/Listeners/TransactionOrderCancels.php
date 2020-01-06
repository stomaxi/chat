<?php

namespace App\Listeners;

use App\Events\NoticeUser;
use App\Events\TransactionOrderCancel;
use App\Repositories\RedisRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class TransactionOrderCancels
{
    protected $set_key = 'cancel_num';
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
     * @param  TransactionOrderCancel  $event
     * @return void
     */
    public function handle(TransactionOrderCancel $event)
    {
        $order = $event->orderOBJ;
        $list = $order->transaction;
        $acc = $list->account;
        $obj = $event->obj;
        DB::beginTransaction();
        try{
            $list->conduct = bcsub($list->conduct, $order->parents_num,2);
            $ret = $list->save();
            if (!$ret){
                DB::rollBack();
                return false;
            }
            $acc->frozen = bcsub($acc->frozen,$order->parents_num,2);
            $acc->flow = bcadd($acc->flow,$order->parents_num,2);
            $acc_ret = $acc->save();
            if (!$acc_ret){
                DB::rollBack();
                return false;
            }
            if ($event->type == 1){
                $pay_ret = $obj->setPayCancelObj($order);
            }else{
                $pay_ret = $obj->setPayOverTime($order);
            }
            if (!$acc_ret){
                DB::rollBack();
                return false;
            }
            DB::commit();
            $this->setCancelNum($order->uid);
            $content = array(
                'type'=>'user_nocite_1',
                'content' => '订单'.$order->order_id.' 用户已取消支付',    //通知内容
                'time' => time(),    //通知时间 -时间戳
            );
            event(new NoticeUser($content,'ORDER',$order->sell_uid));
            return true;
        }catch (\Exception $exception){
            DB::rollBack();
            return false;
        }

    }

    public function setCancelNum($uid)
    {
            $redis = resolve(RedisRepository::class);
            $redis->setUserCancelNum($uid);
    }


}
