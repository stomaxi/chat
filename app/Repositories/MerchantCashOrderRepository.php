<?php
/**
* Created by PhpStorm.
* User: apple GeneratorCommand
* Date: 2020/01/08
* Time: 19:50:46
*/

namespace App\Repositories;
use App\Generator\Repositories\MerchantCashOrderRepositoryTrait;
use App\Storage\Database\MerchantCashOrder;
use Faker\Factory;

class MerchantCashOrderRepository extends  Repository
{
    use MerchantCashOrderRepositoryTrait;

    /**
     *
     * 获取待处理订单
     *
     * @param  $uid int 商户id
     * @return  bool
     * */
    public function getIsExisteWaitOrder($uid)
    {
        $data = MerchantCashOrder::getIsExisteWaitCashOrder([$uid], MerchantCashOrder::TYPE_CASH, MerchantCashOrder::WAIT);
        if ($data){
            return true;
        }
        return false;
    }

    /**
     *
     * 判断商户是否可以提现
     *
     * @param  $uid int 用户id
     * @return bool
     * */
    public function isCash($uid)
    {
        return true;
    }

    /**
     *
     * 新增提现记录
     * */
    public function setCashOrder($uid, $num)
    {
        $data = [
            'uid' => $uid,
            'num' => $num,
            'order' => $this->getOnlyOrderId(),
            'type' => MerchantCashOrder::TYPE_CASH,
        ];
        return $this->store($data);
    }

    /**
     *
     * 获取唯一的订单编号
     *
     * @return  string
     * */
    public function getOnlyOrderId()
    {
        $fack = Factory::create();
        $is_only = false;
        do{
            $order_id = $fack->regexify('[0-9]{6}');
            $is_only = MerchantCashOrder::getOrderIdData($order_id);
        }while($is_only);
        return $order_id;
    }

}