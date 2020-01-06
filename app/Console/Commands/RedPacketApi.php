<?php

namespace App\Console\Commands;

use App\Storage\Database\RedPacket;
use Faker\Factory;
use Illuminate\Console\Command;

class RedPacketApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redpack:api {id} {type=1} {--num=1000} {--order=} {--pay=1} {--envs=1} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '发送红包请求api，测试使用
                    id:商户id
                    type:api类型 1 发送红包，2 查询状态 ,
                    --num:发送的数量，当type为1的时候使用，默认10000,
                    --pay:支持支付方式 1银行卡 2支付宝 4 微信 8 palpay，数字相加，默认只支持 1 银行卡
                    --order:订单id,
                    --envs:请求环境
    ';
    public $id;
    public $type;
    public  $num;
    public  $order;
    public $pay;
    public $env;

//    public $store_url = 'http://10.0.5.81:8083/api/task/add';
//    public $status_url = 'http://10.0.5.81:8083/api/task/status';
//    public $payMoney_url = 'http://10.0.5.81:8083/api/task/pay/money';
//    public $cancel_url = 'http://10.0.5.81:8083/api/task/cancel';


    public $store_url = 'http://10.0.6.113:8019/api/task/add';
    public $status_url = 'http://10.0.6.113:8019/api/task/status';
    public $payMoney_url = 'http://10.0.6.113:8019/api/task/pay/money';
    public $cancel_url = 'http://10.0.6.113:8019/api/task/cancel';



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->id = $this->argument('id');
        $this->type = $this->argument('type');
        $this->num = $this->option('num');
        $this->order = $this->option('order');
        $this->pay = $this->option('pay');
        $this->env = $this->option('envs');//请求环境
        if ($this->env == 2){//线上测试环境
            $this->store_url = 'http://10.0.5.81:8083/api/task/add';
            $this->status_url = 'http://10.0.5.81:8083/api/task/status';
            $this->payMoney_url = 'http://10.0.5.81:8083/api/task/pay/money';
            $this->cancel_url = 'http://10.0.5.81:8083/api/task/cancel';
        }

        $user = $this->getUser();
        if (!$user){
            $this->info('商户不存在');
            return false;
        }
        if ($this->type == 1){//生成订单
            $data = $this->store($user);
            $result = $this->curl($this->store_url, $data, 'POST');

        }elseif ($this->type == 2 ){//查询红包状态
            if(!$this->order){
                $this->info('请输入订单号');
                return false;
            }
            $data = $this->getStatus($user);
            $result = $this->curl($this->status_url, $data, 'POST');
        }elseif ( $this->type == 3 ){
            if(!$this->order){
                $this->info('请输入订单号');
                return false;
            }
            $data = $this->payMoney($user);
            $result = $this->curl($this->payMoney_url, $data, 'POST');
        }elseif ( $this->type == 4 ){
            if(!$this->order){
                $this->info('请输入订单号');
                return false;
            }
            $data = $this->cancel($user);
            $result = $this->curl($this->cancel_url, $data, 'POST');
        }else{
            return false;
        }
        if ($result){
            $this->resultInfo($result);
        }else{
            $this->info('请求失败');
        }


    }

    public function resultInfo($result)
    {
        $data = json_decode($result,true);
        if ($data['statusCode'] != 0){
            dd($data['statusDesc']);
        }else{
            dd($data['data']);
        }

    }

    public function getUser()
    {
        $w = array(
            'app_id' => $this->id
        );
        return resolve(RedPacket::class)->where($w)->first();
    }



    public function sign($data)
    {
        if (!$data || !is_array($data)){
            return false;
        }
        asort($data,SORT_STRING);
        $str = '';
        foreach ($data as $k=>$v){
            $str.= $k.$v;
        }
        return md5($str);
    }

    //新增红包
    public function store(RedPacket $redPacket)
    {
        $data_packet = array(
            'app_id' => $redPacket->app_id,
            'num' => $this->num,
            'time' => time(),
            'rand' => Factory::create()->regexify("[0-9A-Za-z]{32}"),
            'pay' => $this->pay,
            'service' => $redPacket->service,
        );
        $data_packet['sign'] = $this->sign($data_packet);
        return $data_packet;
    }

    //查询红包状态
    public function getStatus(RedPacket $redPacket)
    {
        $data_packet = array(
            'app_id' => $redPacket->app_id,
            'time' => time(),
            'order' => $this->order,
            'service' => $redPacket->service,
        );
        $data_packet['sign'] = $this->sign($data_packet);
        return $data_packet;
    }

    //取消红包
    public function cancel(RedPacket $redPacket)
    {
        $data_packet = array(
            'app_id' => $redPacket->app_id,
            'time' => time(),
            'order' => $this->order,
            'service' => $redPacket->service,
        );
        $data_packet['sign'] = $this->sign($data_packet);
        return $data_packet;
    }



    //付款
    public function payMoney(RedPacket $redPacket)
    {
        $data_packet = array(
            'app_id' => $redPacket->app_id,
            'time' => time(),
            'order' => $this->order,
            'service' => $redPacket->service,
        );
        $data_packet['sign'] = $this->sign($data_packet);
        return $data_packet;
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
}
