<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2019/9/17
 * Time: 14:53
 */

namespace App\Chat;


use App\Repositories\TalkRepository;
use GatewayWorker\Lib\Gateway;
use Illuminate\Support\Facades\Redis;

class Events
{
    public static $redis;
    public static $host = '127.0.0.1';
    public static $password = '';
    public static $database = 1;
    public static $port = 6379;
     //初始化
    public static function onWorkerStart()
    {
        self::connectRedis();
    }

    //链接redis
    public  static  function connectRedis()
    {
        $redis = new \Redis();
        $redis->connect(self::$host, self::$port);
        if (self::$password){
            $redis->auth(self::$password);
        }
        $redis->select(self::$database);
        self::$redis = $redis;
    }




    public static function onConnect($clientId)
    {

        Gateway::sendToClient($clientId, json_encode(array(
            'type'      => 'init',
            'client_id' => $clientId
        )));
    }
    // GatewayWorker建议不做任何业务逻辑，onMessage留空即可
    public static function onMessage($client_id, $message)
    {

    }

    //关闭操作
    public static function onClose($clientId)
    {
        $reids = self::$redis;
        $on_key = TalkRepository::ONLINE;//在线key
        $uid = (int)$reids->zscore($on_key, $clientId);
        if ($uid){
            $off_key = TalkRepository::OFFLINE;
            $reids->sadd($off_key, $uid);
        }
    }
}