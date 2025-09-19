<?php

include '../include.php';

// 1. 手动加载配置参数
$config = include 'pay-partner-config.php';

// 2. 创建微信服务商支付分对象
$payscore = \We::WePayPartnerPayScore($config);
// $payscore = new \WePayPartner\PayScore($config);

// 3. 组装参数，可以参考官方商户文档
$options = [
    'sp_mchid' => $config['sp_mchid'],
    'sub_mchid' => $config['mch_id'],
    'service_id' => '服务ID',
    'out_order_no' => time(),
    'appid' => $config['appid'],
    'sub_appid' => $config['appid'],
    'openid' => 'o38gpszoJoC9oJYz3UHHf6bEp0Lo',
    'sub_openid' => 'o38gpszoJoC9oJYz3UHHf6bEp0Lo',
    'body' => '测试支付分服务',
    'time_range' => [
        'start_time' => '20230101120000',
        'end_time' => '20230101130000'
    ],
    'risk_fund' => [
        'name' => 'ESTIMATE_ORDER_COST',
        'amount' => 1,
        'description' => '测试支付分服务'
    ],
    'attach' => '测试支付分服务',
    'notify_url' => 'http://a.com/text.html'
];

try {
    // 4. 调用创建支付分订单接口
    $result = $payscore->create($options);
    
    // 5. 输出结果
    echo '<pre>';
    var_export($result);
    
} catch (Exception $e) {
    // 6. 出错处理
    echo $e->getMessage() . PHP_EOL;
}