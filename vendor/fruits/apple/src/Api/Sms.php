<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/11/8
 * Time: 18:03
 */

namespace Fruits\Apple\Api;


/**
 * 创蓝接口请求类
 * Class Sms
 * @package Fruits\Apple\Api
 */
class Sms
{
//Interface URL Used to send SMS
    const API_SEND_URL='http://host/sms?';

    //Interface URL Used to Query SMS balance
    const API_BALANCE_QUERY_URL='http://intapi.253.com/balance/json?';

    /**
     *  SMS Account
     * @var string
     */
    protected $account;

    /**
     * @var string
     *
     */
    protected $password;

    public function __construct($account, $password)
    {
        $this->account = $account;
        $this->password= $password;

    }

    /**
     * 发送短信
     *
     * @param string $mobile 		手机号码
     * @param string $msg 			短信内容
     */
    public function send( $mobile, $msg) {



        return ;//请删除
        //短信接入例子
        $extno = "111111";
        $message = urlencode($msg);
        $postArr = array (
            'action'  =>  "p2p",
            'account' =>  $this->account,
            'password' =>  $this->password,
            'extno' => $extno,
            'mobileContentList' => "{$mobile}#hahahaha",
            'rt' => "json",
        );
        $url = "http://host/sms?action=send&account={$this->account}&content=$message&password={$this->password}&extno=$extno&rt=json&mobile={$mobile}";

        $result = $this->curlPost( $url , $postArr);


        return $result;
    }




    /**
     * 查询额度
     *
     *  查询地址
     */
    public function queryBalance() {

        //查询参数
        $postArr = array (
            'account' => $this->account,
            'password' => $this->password,
        );
        $result = $this->curlPost(self::API_BALANCE_QUERY_URL, $postArr);
        return $result;
    }

    /**
     * 通过CURL发送HTTP请求
     * @param string $url  //请求URL
     * @param array $postFields //请求参数
     * @return mixed
     */
    private function curlPost($url,$postFields){
        $postFields = json_encode($postFields);
        $ch = curl_init ();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8'
            )
        );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt( $ch, CURLOPT_TIMEOUT,1);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec ( $ch );
        if (false == $ret) {
            $result = curl_error(  $ch);
        } else {
            $rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
            if (200 !== $rsp) {
                $result = "请求状态 ". $rsp . " " . curl_error($ch);
            } else {
                $result = $ret;
            }
        }
        curl_close ( $ch );
        return $result;
    }
}