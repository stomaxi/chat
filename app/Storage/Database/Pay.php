<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/18
 * Time: 14:45:12
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\PayTrait;

class Pay extends Database
{
    use PayTrait;
    protected $table = 'pay';
    protected $fillable = ['uid','pay_id','name', 'account','pay_pic','other',];
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'uid' => 'uid',
        'pay_id' => 'payId',
        'name' => 'name',
        'account' => 'account',
        'pay_pic' => 'payPic',
        'other' => 'other',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'deleted_at' => 'deletedAt',
    ];




}