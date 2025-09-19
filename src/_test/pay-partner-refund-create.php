<?php

include '../include.php';

// 1. 手动加载配置参数
$config = include 'pay-partner-config.php';

// 2. 创建微信服务商订单对象
$order = \We::WePayPartnerOrder($config);
// $order = new \WePayPartner\Order($config);

// 3. 组装参数，可以参考官方商户文档
$options = [
    'sub_mchid' => $config['mch_id'],
    'out_trade_no' => '商户订单号',
    'out_refund_no' => time(),
    'amount' => [
        'refund' => 1,
        'total' => 1,
        'currency' => 'CNY'
    ],
    'reason' => '退款原因'
];

try {
    // 4. 调用申请退款接口
    $result = $order->createRefund($options);
    
    // 5. 输出结果
    echo '<pre>';
    var_export($result);
    
} catch (Exception $e) {
    // 6. 出错处理
    echo $e->getMessage() . PHP_EOL;
}