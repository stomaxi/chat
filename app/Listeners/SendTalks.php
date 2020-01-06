<?php

namespace App\Listeners;

use App\Events\SendTalk;
use App\Notifications\PushNotice;
use App\Repositories\TalkRepository;
use App\Repositories\UserRepository;
use App\Storage\Database\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GatewayWorker\Lib\Gateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;

class SendTalks
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendTalk  $event
     * @return void
     */
    public function handle(SendTalk $event)
    {
        if ($event->is_group == 1){
            $user = Auth::user();
            if(isset($user->groupchat)){
                $group_num = $user->groupchat;
            }else{
                $user = resolve(UserRepository::class)->storage()->find($event->uid);
                $group_num = $user->groupchat;
            }
            $this->sendGroup($group_num ,$event->content);
        }else{
            $this->sendUser($event->uid ,$event->content);
        }
    }

    //发送给当前用户的群
    public function sendGroup($group,$content)
    {
        $result = $this->saveGrpupChat($group,$content);
        $chat_id = false;
        if ($result){
            $chat_id = $result;
        }
        $this->sendMemberOnline($group,$content);
        $this->sendMemberOffline($group,$content,$chat_id);
        //保存聊天消息
    }

    /**
     *
     *  保存用户聊天信息 不需要保存信息类型及保存失败返回false
     *
     * @param $group int 群id
     * @param $content array 发送内容
     * @return mixed
     * */
    public function saveGrpupChat($group,$content)
    {
        $type = $this->getSaveType($content['type']);
        if (!$type){
            return false;
        }
        $uid = isset($content['uid'])?$content['uid']:0;
        $data = [
            'uid' => $uid,
            'type' => $type,
            'content' => json_encode($content,256),
            'groups' => $group
        ];
        $ret = resolve(TalkRepository::class)->store($data);
        if ($ret){
            return $ret->id;
        }
        return false;

    }

    /**
     *
     *  获取保存类型,不保存返回false，保存返回type类型
     *
     * @param $type string 聊天类型
     * @return mixed
     * */
    public function getSaveType($type)
    {
        $save_type = [
            'say' => 1,
            'red_packet' => 2,
            'red_packet_success' => 3,
        ];
        if (isset($save_type[$type])){
            return $save_type[$type];
        }
        return false;
    }




    /**
     *
     *  群聊发送给在线的
     *
     * @param  $group int 群id
     * @param  $content array 内容
     * @return  bool
     * */
    public function sendMemberOnline($group,$content)
    {
        Gateway::$registerAddress = config('share.webSocket.registerAddress');
        Gateway::sendToGroup($group, json_encode($content));
        return true;
    }

    /**
     *
     *  群聊发送给未在线的用户
     *
     * @param  $group int 群id
     * @param  $content array 内容
     * @param $chat_id int 聊天id
     * @return  bool
     * */
    public function sendMemberOffline($group,$content, $chat_id)
    {
        $type = $this->getSaveType($content['type']);
        if ($type){//存在类型推送
            $uids = $this->getOfflineUser();
            if ($uids){
                $users = $this->getUser($uids);
                $this->sendPush($users, $content);
                $this->saveUnread($uids, $chat_id);
            }
        }
    }


    /**
     *
     * 保存聊天未读记录
     *
     * @param $ids array 用户id数组
     * @param $chat_id int 聊天id
     * @return bool
     * */
    public function saveUnread($ids, $chat_id)
    {
        $new_time = time();
        $valid_time = time()+config('share.group.chat_save_time');
        if (is_array($ids)){
            foreach ($ids as $value){
                $key = resolve(TalkRepository::class)->getUnreadKey($value);
                $read = Redis::ZADD($key,$valid_time, $chat_id);
               Redis::ZREMRANGEBYSCORE($key,0, $new_time);
            }
        }
        return true;
    }




    /**
     *
     *  推送给离线用户信息
     *
     * */
    public function sendPush($users, $content)
    {
        Notification::send($users,new PushNotice($content));
    }

    /**
     *
     *  获取未在线的用户信息
     *
     * */
    public function getOfflineUser()
    {
        $users = [];
        $key = TalkRepository::OFFLINE;
        $ids = Redis::SMEMBERS($key);
        return $ids;
    }

    /**
     *
     * 获取指定用户id用户数据
     *
     * @param  $ids mixed 用户id数组或者id
     * @return  User模型集合
     * */
    public function getUser($ids)
    {
        if (!is_array($ids)){
            $ids = [$ids];
        }
        return User::whereIn('id', $ids)->get();
    }




    //发送给个人
    public function sendUser($uid, $content)
    {
        $is = $this->isOffline($uid);//是否离线
        if ($is){//离线推送
            $user = $this->getUser($uid);
            $this->sendPush($user, $content);
        }else{
            $this->sendOnlineUser($uid, $content);
        }
    }




    /**
     *
     *  发送给在线用户
     *
     * @param $uid int 用户id
     * @param $content array 发送内容
     * @return  bool
     * */
    public function sendOnlineUser($uid, $content)
    {
        Gateway::$registerAddress = config('share.webSocket.registerAddress');
        Gateway::sendToUid($uid, json_encode($content,256));
        return true;
    }




    /**
     *
     *  判断指定id是否离线
     *
     * @param  $uid int 用户id
     * @param bool
     * */
    public function isOffline($uid)
    {
        $offfline = TalkRepository::OFFLINE;
        $is = Redis::SISMEMBER($offfline, $uid);
        if ($is == 1){
            return true;
        }
        return false;
    }


}
