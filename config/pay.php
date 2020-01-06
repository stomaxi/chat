<?php

$cdn = "http://10.0.5.81:5001";
return [
    'list'=>[
        '1' => [
            'id' => 1,
            'name' => '银行卡',
            'pic' => "{$cdn}/images/pay/card-orange.png",
            'is_more' => true,//是否可以多张
            'is_code' => false,//是否必须上传二维码
            'is_list' => true,//是否限定list
            'list' => [
                0 => '建设银行',
                1 => '招商银行',
                2 => '中国银行',
                3 => '工商银行',
            ],
        ],
        '2' => [
            'id' => 2,
            'name' => '支付宝',
            'pic' => "{$cdn}/images/pay/Paytreasure.png",
            'is_more' => false,
            'is_code' => true,
            'is_list' => false,
            'list' => [
            ],
        ],
        '4' => [
            'id' => 4,
            'name' => '微信',
            'pic' => "{$cdn}/images/pay/WeChat.png",
            'is_more' => false,
            'is_code' => true,
            'is_list' => false,
            'list' => [
            ],
        ],
        '8' => [
            'id' => 8,
            'name' => 'PayPal',
            'pic' => "{$cdn}/images/pay/PayPal.png",
            'is_more' => false,
            'is_code' => false,
            'is_list' => false,
            'list' => [
            ],
        ],
    ],
    'default' => 1,//实名制使用银行卡
];