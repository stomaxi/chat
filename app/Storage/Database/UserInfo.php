<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/18
 * Time: 17:23:08
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\UserInfoTrait;

class UserInfo extends Database
{
    use UserInfoTrait;
    protected $table = 'user_infos';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'uid' => 'uid',
        'type' => 'type',
        'name' => 'name',
        'card' => 'card',
        'mobile' => 'mobile',
        'jy_password' => 'jyPassword',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    public function getOne($uid)
    {
        $w = array(
            'uid' => $uid
        );
        return $this->where($w)->first();
    }

}