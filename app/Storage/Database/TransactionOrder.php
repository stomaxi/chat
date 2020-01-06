<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/20
 * Time: 16:12:07
 */

namespace App\Storage\Database;

use App\Events\NoticeUser;
use App\Events\TransactionOrderCancel;
use App\Storage\Database;
use App\Generator\Storage\Database\TransactionOrderTrait;
use Illuminate\Support\Facades\DB;

class TransactionOrder extends Database
{
    use TransactionOrderTrait;
    protected $table = 'transaction_orders';
    //TODO please complete $fields
    protected const GENERATE = 1;//生成订单
    protected const PAYMENT = 2;//买家已付款
    protected const CANCEL = 3;//买家取消
    protected const OVERTIME = 4;//买家超时付款
    protected const  NO_COLLECT_MONEY = 5;//卖家未收钱
    protected const  NO_COLLECT_CURRENCY = 6;//卖家超时未点付币
    protected const  SUCCESS = 7;//卖家已付币
    protected const BUY_COMPLAINT = 8;//买家申诉
    protected const SELL_COMPLAINT = 9;//卖家申诉

    protected $fillable = [
        "order_id",
        "uid",
        "transactions_id",
        "num",
        "parents_num",
        "get_num",
        "pay_type",
        "pay_rand",
        "pay_list",
        "term_of_validity",
        'sell_uid',
    ];
    protected $fields = [
        'id' => 'id',
        'order_id' => 'orderId',
        'uid' => 'uid',
        'transactions_id' => 'transactionsID',
        'num' => 'num',
        'pay_type' => 'payType',
        'pay_list' => 'payList',
        'pay_num' => 'payNum',
        'term_of_validity' => 'termOfValidity',
        'status' => 'status',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    //关联关系
    public function transaction()
    {
        return $this->belongsTo('App\Storage\Database\Transaction','transactions_id','order_id');
    }

    public function account()
    {
        return $this->belongsTo('App\Storage\Database\Account','uid','uid');
    }

    public function user()
    {
        return $this->belongsTo('App\Storage\Database\User','uid','id');
    }
    public function userInfo()
    {
        return $this->belongsTo('App\Storage\Database\UserInfo','uid','uid');

    }

    //卖家已付款
    public function setPayMent($order,$uid)
    {
        $w = array(
            'order_id' => $order,
            'status' => self::GENERATE,
            array('term_of_validity','>',time()),
            'uid' => $uid
        );
        $data = $this->where($w)->first();
        if (!$data){
            return false;
        }
        $data->status = self::PAYMENT;
        $data->pay_money_time = time();
        $ret = $data->save();
        if ($ret){
            $content = array(
                'type'=>'user_nocite_1',
                'content' => '订单 '.$order .'买家已付款，请注意查收！',
                'time' => time(),
            );
            event(new NoticeUser($content,'ORDER',$data->sell_uid));
            return true;
        }else{
            return false;
        }
    }

    //卖家取消接口处理
    public function setPayCancel($order,$uid)
    {
        $w = array(
            'order_id' => $order,
            'status' => self::GENERATE,
            array('term_of_validity','>',time()),
            'uid' => $uid
        );
        $data = $this->where($w)->first();
        if (!$data){
            return false;
        }
        $ret = event(new TransactionOrderCancel($data,$this));
        return true;
    }

    //修改卖家取消状态
    public function setPayCancelObj($dataObj)
    {
        $dataObj->status = self::CANCEL;//买家取消
        return $dataObj->save();
    }

    //设置卖家超时状态
    public function setPayOverTime($dataObj)
    {
        $dataObj->status = self::OVERTIME;//买家超时付款
        return $dataObj->save();
    }

    //获取所有的过期订单
    public function getExpires()
    {
        $w = array(
            'status' => self::GENERATE,
            array('term_of_validity','<',time()),
        );
        return $this->where($w)->get();
    }

    //设置未收款
    public function setNoCollectMoney($order,$uid)
    {
        $w = array(
            'order_id' => $order,
            'status' => self::PAYMENT,
        );
        $data = $this->where($w)->first();
        if (!$data){
            return false;
        }
        $list = $data->transaction;
        if ($list->uid != $uid){
            return false;
        }
        $data->status = self::NO_COLLECT_MONEY;
        $ret = $data->save();
        if (!$ret){
               return false;
        }
        return true;

    }

    //获取当前用户待处理订单
    public function getGenerateCount($uid)
    {
        $w = array(
            'status' => self::GENERATE,
            'uid' => $uid,
        );
        return $this->where($w)->count();
    }


    //获取卖家已付款订单详情
    public function getPayCurrency($order)
    {
        $w = array(
            'order_id' => $order,
//            array('pay_money_time','>',time()-config('share.order_pay_currency_overtime')),
        );
        $in = array(self::PAYMENT,self::NO_COLLECT_CURRENCY);
        return $this->where($w)->whereIn('status', $in)->first();
    }
    //卖家确定付币
    public function setPayCurrrency(TransactionOrder $order)
    {
        if ($order->status != self::PAYMENT && $order->status != self::NO_COLLECT_CURRENCY){
            return false;
        }
        $order->status = self::SUCCESS;
        $order->pay_currency_time = time();
        return $order->save();
    }

    //获取用户未付币信息
    public function getNoPayCurrency()
    {
        $w = array(
            'status' => self::PAYMENT,
            array('pay_money_time','<',time()-config('share.order_pay_currency_overtime') ),
        );
        return $this->where($w)->get();

    }

    //设置超时未付币
    public function setNoPayCurrency(TransactionOrder $order)
    {
        $order->status = self::NO_COLLECT_CURRENCY;
        return $order->save();
    }

    //查询指定挂单ids的出售总数
    public function sumOrderCurrencys(array $orders)
    {
        $w = array(
            'status' => self::SUCCESS,
        );
        return $this->where($w)->whereIn('transactions_id', $orders)->sum('parents_num');
    }

    //设置买家申诉
    public function setBuyComplaint(TransactionOrder $order){
        if(!in_array($order->status, array(self::NO_COLLECT_CURRENCY,self::NO_COLLECT_MONEY))){
            return false;
        }
        $order->status = self::BUY_COMPLAINT;
        return $order->save();
    }

    //卖家申诉
    public function setSellComplaint(TransactionOrder $order)
    {
        if(!in_array($order->status, array(self::NO_COLLECT_CURRENCY,self::NO_COLLECT_MONEY))){
            return false;
        }
        $order->status = self::SELL_COMPLAINT;
        return $order->save();
    }




}