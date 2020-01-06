<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/19
 * Time: 15:07:01
 */

namespace App\Storage\Database;

use App\Storage\Database;
use App\Generator\Storage\Database\AccountTrait;

class Account extends Database
{
    use AccountTrait;
    protected $table = 'accounts';
    //TODO please complete $fields
    protected $fields = [
        'id' => 'id',
        'uid' => 'uid',
        'flow' => 'flow',
        'frozen' => 'frozen',
        'reward' => 'reward',
        'status' => 'status',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    public function flow()
    {
        return $this->hasMany('App\Storage\Database\Flow','uid','uid');
    }
    public function user()
    {
        return $this->hasOne('App\Storage\Database\User','id','uid');

    }
    //获取当前群聊任务奖励的排名信息
    public function getTaskTotalOrderBy()
    {
        //默认一个群聊
        $w = array(
            array('task', '>', 0)
        );
        return $this->with('user')->where($w)->orderBy('task','desc')->limit(config('share.group.group_num'))->get();
    }
}