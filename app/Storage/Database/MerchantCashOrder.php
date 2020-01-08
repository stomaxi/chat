<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2020/01/08
 * Time: 19:50:46
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\MerchantCashOrderTrait;

class MerchantCashOrder extends Database
{
    use MerchantCashOrderTrait;
    protected $table = 'merchant_cash_order';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'uid' => 'uid',
        'order' => 'order',
        'type' => 'type',
        'status' => 'status',
        'num' => 'num',
        'admin_uid' => 'admin_uid',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'deleted_at' => 'deletedAt',
    ];

    const WAIT = 1;//待处理


    const TYPE_CASH = 1;//类型 提现申请


    /**
     *
     * 查询指定用户是否存在指定状态的订单记录
     *
     * @param $uid int 用户id
     * @param  $status int 状态
     * @return  bool
     * */
    public static function getIsExisteWaitCashOrder($uid,$type,$status)
    {
        $w = [
            'type' => $type,
            'status' => $status,
            'uid' => $uid,
        ];
        $data = self::where($w)->first();
        if ($data){
            return true;
        }
        return false;
    }


    /**
     *
     * 获取指定订单编号数据
     *
     * @param  $order int order id
     * @return  MerchantCashOrder 模型
     * */
    public static function getOrderIdData($order)
    {
        $w = [
            'order' => $order
        ];
        return self::where($w)->first();
    }

}