<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/25
 * Time: 18:09:29
 */

namespace App\Storage\Database;

use App\Events\NoticeUser;
use App\Events\SendTalk;
use App\Storage\Database;
use App\Generator\Storage\Database\TaskTrait;
use App\Events\RedPacketFun;

class Task extends Database
{
    use TaskTrait;
    protected $table = 'tasks';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'send_uid' => 'sendUid',
        'num' => 'num',
        'price' => 'price',
        'money' => 'money',
        'status' => 'status',
        'repeat_num' => 'repeatNum',
        'efffet_at' => 'efffetAt',
        'uid' => 'uid',
        'pay' => 'pay',
        'task_at' => 'taskAt',
        'complaints_at' => 'complaintAt',
        'get_money_at' => 'getMoneyAt',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'deleted_at' => 'deletedAt',
    ];
    protected $fillable = [
        'order',
        'send_uid',
        'num',
        'price',
        'money',
        'status',
        'repeat_num' ,
        'efffet_at',
        'use_pay',
    ];

     const ORDER_GANERATE = 1;//生成订单
     const ORDER_RECEIPT = 2;//用户接单
     const ORDER_NORECEIPT = 3;//订单过期
     const ORDER_PAYMONEY = 4;//商户已付款
     const ORDER_PAYCURRENCY = 5;//用户已付币
     const ORDER_NO_PAYMONEY = 6;//商户付币异常
     const ORDER_NO_PAYCURRENCY = 7;//用户付币异常
     const ORDER_PAY_MONEY_CANCEL = 8;//商户超时未付钱，取消
     const ORDER_CANCEL = 9;//商户主动取消


    public function user()
    {
        return $this->belongsTo('App\Storage\Database\User','send_uid','id');
    }//

    public function getUser()
    {
        return $this->belongsTo('App\Storage\Database\User','uid','id');

    }

    public function complaints()
    {
        return $this->hasOne('App\Storage\Database\Complaint','order','order');
    }

    //获取买家账户信息 -
    public function getBuyAccount()
    {
        return $this->hasOne('App\Storage\Database\Account','uid','send_uid');

    }

    //获取买家账户信息 -
    public function getSellAccount()
    {
        return $this->hasOne('App\Storage\Database\Account','uid','uid');

    }


    public function getEffect($order)
    {
        $w = array(
            'order' => $order,
            array('efffet_at', '>', time()),
            'status' => self::ORDER_GANERATE,
        );
        return $this->where($w)->first();
    }

    //修改用户订单
    public function setReceipt($order, $uid,$pay)
    {
        $task = $this->getEffect($order);
        if ($task->status == 1){
            $task->status = self::ORDER_RECEIPT;
            $task->uid = $uid;
            $task->task_at = time();
            $task->pay = json_encode($pay);
            $task->complaints_at = time()+config('share.red_packet.complaints_at');
            return $task->save();
        }
        return false;
    }

    //商户付款
    public function setPayMoney(Task $task)
    {
        if ($task->status != 2 || $task->complaints_at < time()){
            return false;
        }
        $task->status = self::ORDER_PAYMONEY;
        $task->get_money_at = time();
        $task->complaint_user_at = time()+config('share.red_packet.complaints_at_user');
        return $task->save();
    }

    //商户超时取消订单
    public function setPayMoneyCancel(Task $task, $currency_num)
    {
        $task->status = self::ORDER_PAY_MONEY_CANCEL;
        $task->cancel_at = time();
        $task->cancel_reward = $currency_num;
        return $task->save();

    }

    //商户主动取消订单
    public function setCancel(Task $task, $currency_num)
    {
        $task->status = self::ORDER_CANCEL;
        $task->cancel_at = time();
        $task->cancel_reward = $currency_num;
        return $task->save();
    }

    //查询用户可用支付币种订单
    public function getPayCurrencyOrder($order, $uid)
    {
        $w = array(
            'uid' => $uid,
            'order' => $order,
        );
        $in = [
            self::ORDER_PAYMONEY,
            self::ORDER_RECEIPT
        ];
        return $this->where($w)->whereIn('status', $in)->first();
    }

    //修改订单状态--用户确定付币
    public  function setPayCurrency(Task $task)
    {
        if ($task->status != self::ORDER_PAYMONEY && $task->status != self::ORDER_RECEIPT ){
            return false;
        }
        $task->status = self::ORDER_PAYCURRENCY;
        $task->get_currency_at = time();
        $ret = $task->save();
        if ($ret){
            //修改账户获得的币总数
            $acc = $task->getSellAccount;
            $total = bcadd($acc->task, $task->num,2);
            $acc->task = $total;
            $acc->save();
            //修改等级
            $grade = $this->comGrade($total);
            $user = $task->getUser;
            if ($user->grade !== (int)$grade){
                $user->grade = $grade;
                $ret = $user->save();
                $content = array(
                    'type'=>'user_nocite_1',
                    'grade' => $grade,
                    'content' => '恭喜您，等级提升至'.$grade,    //通知内容
                    'time' => '',    //通知时间 -时间戳
                );
                event(new NoticeUser($content,'SYS',$user->id));
            }
            return true;
        }
        return false;
    }

    public function comGrade($total)
    {
        $grade_num = config('gradeNum');
        $count = count($grade_num);
        $key = 0;
        foreach ($grade_num as $k=>$v){
            if($k == 1){
                if (bccomp($v, $total, 0)){
                    break;
                }
            }elseif ($k>1 && $k< $count){
                if ($v>$total && $v< $grade_num[$k+1]){
                    $key = $k;
                    break;
                }

            } else{
                $key = $count;
            }
        }
        return $key;
    }


    //获取用户可用投诉的指定订单
    public function getComplaintOrder($order, $uid){
        $w = array(
            'uid' => $uid,
            'status' => self::ORDER_PAYMONEY,
            'order' => $order,
            array('complaints_at','<',time()),
        );
        return $this->where($w)->first();
    }
//设置投诉订单
    public function setComplaintOrder($order, $uid){
        $w = array(
            'uid' => $uid,
            'status' => 4,
            'order' => $order,
            array('complaints_at','<',time()),
        );
        $task = $this->where($w)->first();
        $task->status = self::ORDER_NO_PAYMONEY;
        $task->set_complaints_at = time();
        $notice = array(
            'type' => 3,
            'order' => $order,
            'pay' => '',
            'money' => '',
            'content' => '用户投诉当前订单',
        );
        event(new RedPacketFun($task->send_uid,$notice));
        return $task->save();
    }


    public function addRedComplaint($order, $send_id)
    {
        $w = array(
            'order' => $order,
            'send_uid' => $send_id,
        );
        $task = $this->where($w)->first();
        if ($task->status !== self::ORDER_PAYMONEY){
            return '当前用户未支付';
        }
        if ($task->complaint_user_at > time()){
            return '请等待用户付款，超时才可投诉';
        }
        $task->status = self::ORDER_NO_PAYCURRENCY;
        $task->set_complaints_at = time();
        $ret = $task->save();
        if (!$ret){
            return '请求失败！';
        }
        return true;
    }

    public function setOverTime(Task $task)
    {
        $task->status = self::ORDER_NORECEIPT;
        $ret = $task->save();
        if ($ret){
            $notice = array(
                'type' => 4,
                'order' => $task->order,
                'pay' => '',
                'money' => '',
                'content' => '任务无人接单，已取消',
            );
            event(new RedPacketFun($task->send_uid,$notice));
            return true;
        }
        return false;
    }

    //从新发送红包
    public function resetRedPacket(Task $task, $time)
    {
        if ($task->status == 1 && $task->efffet_at < time() && $task->repeat_num < config('share.red_packet.repeat_num')){
            $task->status = self::ORDER_GANERATE;
            $task->repeat_num = ($task->repeat_num+1);
            $task->efffet_at = $time+config('share.red_packet.efffet_at');
            return $task->save();
        }
        return false;
    }


    //获取交易记录
    public function getDatas($user,$type, $page,$num,$tag = 0)
    {
        $in = array();
        if ($type == 1){//交易中的
            $in = array(self::ORDER_RECEIPT,self::ORDER_PAYMONEY);
        }elseif ($type == 2){//已完成
            $in = array(self::ORDER_PAYCURRENCY);
        }elseif ($type == 3){//已取消
            $in = array(self::ORDER_PAY_MONEY_CANCEL,self::ORDER_CANCEL);
        }elseif($type == 4){//申诉中
            $in = array(self::ORDER_NO_PAYMONEY,self::ORDER_NO_PAYCURRENCY);
        }else{
            return false;
        }
        $w = array();
        if ($tag != 1){
            $w =array(
                'uid'=> $user->id
            );
        }
        $offset = ($page-1)*$num;
        $data = $this->with('user','getUser')->whereIn('status', $in)->where($w)->orderBy('created_at', 'desc')->offset($offset)->limit($num)->get();
        $total = $this->with('user','getUser')->whereIn('status', $in)->where($w)->count();
        return [
            'data' => $data,
            'total' => $total
        ];
    }

}