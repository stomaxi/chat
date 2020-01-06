<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/19
 * Time: 20:47:30
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\TransactionTrait;

class Transaction extends Database
{
    use TransactionTrait;

    protected const ORDER_CANCEL = 2;

    protected $table = 'transactions';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'order_id' => 'orderId',
        'uid' => 'uid',
        'total' => 'total',
        'surplus' => 'surplus',
        'min' => 'min',
        'max' => 'max',
        'price' => 'price',
        'remarks' => 'remarks',
        'pay_type' => 'payType',
        'pay_list' => 'payList',
        'status' => 'status',
        'term_of_validity' => 'termOfValidity',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    //失效
    public function cancel($id)
    {
        $data = $this->find($id);
        $data->status = self::ORDER_CANCEL;
        return $data->save();
    }

    //用户对应
    public function user(){
        return $this->belongsTo('App\Storage\Database\User','uid','id');
    }

    //账户对应
    public function account()
    {
        return $this->belongsTo('App\Storage\Database\Account','uid','uid');
    }


}