<?php

return [
    // 开启调用发送短信接口出错会直接输出错误
    'debug' => true,
    // HTTP 请求的超时时间（秒）    
    'timeout' => 5.0,
    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
        // 默认可用的发送网关
        'gateways' => [
            'yuntongxun'
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '../runtime/easy-sms.log',
        ],
        //容联云通讯
        //短信内容使用 template + data
        'yuntongxun' => [
            'app_id'         => '',
            'account_sid'    => '',
            'account_token'  => '',
            'is_sub_account' => false,
        ]
    ],
];
