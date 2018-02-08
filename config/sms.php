<?php
$config = [
    /*
   |--------------------------------------------------------------------------
   | HTTP 请求的超时时间
   |--------------------------------------------------------------------------
   |
   | 设置 HTTP 请求超时时间，单位为「秒」。可以为 int 或者 float。
   |
   */
    // HTTP 请求的超时时间（秒）
    'timeout' => 5.0,
    /*
    |--------------------------------------------------------------------------
    | 默认发送配置
    |--------------------------------------------------------------------------
    |
    | strategy 为策略器，默认使用「顺序策略器」，可选值有：
    |       - \Overtrue\EasySms\Strategies\OrderStrategy::class  顺序策略器
    |       - \Overtrue\EasySms\Strategies\RandomStrategy::class 随机策略器
    |
    | gateways 设置可用的发送网关，可用网关：
    |       - aliyun 阿里云信
    |       - alidayu 阿里大于
    |       - yunpian 云片
    |       - submail Submail
    |       - luosimao 螺丝帽
    |       - yuntongxun 容联云通讯
    |       - huyi 互亿无线
    |       - juhe 聚合数据
    |       - sendcloud SendCloud
    |       - baidu 百度云
    |
    */
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
        // 默认可用的发送网关
        'gateways' => ['aliyun'],
    ],
    /*
   |--------------------------------------------------------------------------
   | 发送网关配置
   |--------------------------------------------------------------------------
   |
   | 可用的发送网关，基于网关列表，这里配置可用的发送网关必要的数据信息。
   |
   */
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun' => [
            'access_key_id' => 'LTAIXijUalhN321o',
            'access_key_secret' => 'd0ouwDjnRV7CpG5M1EptbAIhnYJQlD',
            'sign_name' => '畅想购',
        ],
        'gateway_aliases' => [
            'aliyun' => \Overtrue\EasySms\Gateways\AliyunGateway::class,
            'alidayu' => \Overtrue\EasySms\Gateways\AlidayuGateway::class,
        ],
    ],

];
return $config;