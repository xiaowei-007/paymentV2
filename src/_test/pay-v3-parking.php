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
    // 创建停车服务对象
    $parking = \We::WePayV3Parking($config);
    // $parking = new \WePayV3\Parking($config);

    // 创建停车入场示例
    $createData = [
        'out_parking_no' => time(),
        'plate_number' => '粤B12345',
        'plate_color' => 'BLUE',
        'start_time' => date('Y-m-d H:i:s'),
        'parking_name' => '测试停车场',
        'free_duration' => 30, // 免费时长，单位分钟
        'notify_url' => 'https://yourdomain.com/notify',
    ];

    $result = $parking->create($createData);
    Tools::pushFile('parking_create_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "创建停车入场成功:\n";
    print_r($result);

    // 扣费受理示例
    $payData = [
        'out_trade_no' => time(),
        'plate_number' => '粤B12345',
        'plate_color' => 'BLUE',
        'start_time' => date('Y-m-d H:i:s', strtotime('-1 hour')),
        'end_time' => date('Y-m-d H:i:s'),
        'parking_name' => '测试停车场',
        'charging_duration' => 30, // 计费时长，单位分钟
        'fee' => 1000, // 费用，单位为分
        'notify_url' => 'https://yourdomain.com/notify',
    ];

    $payResult = $parking->pay($payData);
    Tools::pushFile('parking_pay_result.json', json_encode($payResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "扣费受理成功:\n";
    print_r($payResult);

    // 查询订单示例
    $queryResult = $parking->query($payData['out_trade_no']);
    Tools::pushFile('parking_query_result.json', json_encode($queryResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "查询订单成功:\n";
    print_r($queryResult);

} catch (Exception $e) {
    echo "停车服务操作失败: " . $e->getMessage() . "\n";
}