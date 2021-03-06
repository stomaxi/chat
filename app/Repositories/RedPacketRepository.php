<?php
/**
* Created by PhpStorm.
* User: apple GeneratorCommand
* Date: 2019/09/26
* Time: 11:15:07
*/

namespace App\Repositories;
use App\Generator\Repositories\RedPacketRepositoryTrait;
use Illuminate\Support\Facades\Log;

class RedPacketRepository extends  Repository
{
    use RedPacketRepositoryTrait;

    public function addUser($uid, $service, $url)
    {
        $obj = $this->storage();
        $obj->app_id = $uid;
        $obj->service = $service;
        $obj->url = $url;
        return $obj->save();
    }


    public function send($app_id,$data){
        $userObj = resolve(UserRepository::class);
        $user = $userObj->getOne($app_id);
        $packet =  $user->red_packets;
        return $this->curl($packet->url,$data,'POST');
    }


    public function curl($url, $data,$method= 'GET')
    {
        $curl = curl_init();
        if ($method == "GET") {
            $str = $url . '?';
            $url = $url . '?' . http_build_query($data);
        }
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        if ($method == "POST"){
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt ( $curl ,  CURLOPT_POSTFIELDS ,  $data );
        }
        $ret = curl_exec($curl);
        curl_close($curl);


        return $ret;
    }

    public function getMode($app_id)
    {
        $w = [
            'app_id' => $app_id,
        ];
        return $this->storage()->where($w)->first();
    }


}