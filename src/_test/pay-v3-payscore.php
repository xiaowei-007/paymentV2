<?php

use WeChat\Contracts\Tools;

include '../include.php';

// 配置参数
$config = [
    'appid' => 'your_app_id',
    'mch_id' => 'your_mch_id',
    'mch_v3_key' => 'your_mch_v3_key',
    'cert_public' => 'your_cert_public_path_or_content',
    'cert_private' => 'your_cert_private_path_or_content',
];

try {
    // 创建支付分对象
    $payscore = \We::WePayV3PayScore($config);
    // $payscore = new \WePayV3\PayScore($config);

    // 创建支付分订单示例
    $createData = [
        'out_order_no' => time(),
        'service_id' => 'your_service_id',
        'service_introduction' => '测试服务',
        'risk_amount' => 10000, // 风险金额，单位为分
        'time_range' => [
            'start_time' => date('Y-m-d H:i:s'),
            'end_time' => date('Y-m-d H:i:s', strtotime('+1 hour')),
        ],
        'notify_url' => 'https://yourdomain.com/notify',
    ];

    $result = $payscore->create($createData);
    Tools::pushFile('payscore_create_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "创建支付分订单成功:\n";
    print_r($result);

    // 查询支付分订单示例
    $queryResult = $payscore->query($createData['out_order_no'], $createData['service_id']);
    Tools::pushFile('payscore_query_result.json', json_encode($queryResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "查询支付分订单成功:\n";
    print_r($queryResult);

} catch (Exception $e) {
    echo "支付分操作失败: " . $e->getMessage() . "\n";
}