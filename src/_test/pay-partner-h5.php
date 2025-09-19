<?php

include '../include.php';

// 1. 手动加载配置参数
$config = include 'pay-partner-config.php';

// 2. 创建微信服务商支付对象
$order = \We::WePayPartnerOrder($config);
// $order = new \WePayPartner\Order($config);

// 3. 组装参数，可以参考官方商户文档
$options = [
    'sp_appid' => $config['sp_appid'],
    'sp_mchid' => $config['sp_mchid'],
    'sub_appid' => $config['appid'],
    'sub_mchid' => $config['mch_id'],
    'description' => '测试商品',
    'out_trade_no' => time(),
    'notify_url' => 'http://a.com/text.html',
    'amount' => [
        'total' => 1,
        'currency' => 'CNY'
    ],
    'scene_info' => [
        'payer_client_ip' => '127.0.0.1',
        'h5_info' => [
            'type' => 'Wap'
        ]
    ]
];

try {
    // 4. 调用H5支付
    $result = $order->create(\WePayPartner\Order::WXPAY_H5, $options);
    
    // 5. 输出结果
    echo '<pre>';
    var_export($result);
    
} catch (Exception $e) {
    // 6. 出错处理
    echo $e->getMessage() . PHP_EOL;
}