<?php

use WeChat\Contracts\Tools;

include '../include.php';

// 配置参数
$config = [
    'sp_mchid' => 'your_sp_mchid',
    'mch_v3_key' => 'your_mch_v3_key',
    'cert_public' => 'your_cert_public_path_or_content',
    'cert_private' => 'your_cert_private_path_or_content',
    'appid' => 'your_appid',
    'mch_id' => 'your_mch_id',
];

try {
    // 创建消费者投诉对象
    $complaint = \We::WePayPartnerComplaint($config);
    // $complaint = new \WePayPartner\Complaint($config);

    // 1. 查询投诉单列表
    $listParams = [
        'limit' => 5,
        'offset' => 0,
        'begin_date' => '2023-01-01',
        'end_date' => '2023-01-31'
    ];
    $listResult = $complaint->list($listParams);
    Tools::pushFile('complaint_list_result.json', json_encode($listResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "查询投诉单列表成功:\n";
    print_r($listResult);

    // 2. 查询投诉单详情（需要真实的投诉单号）
    // $complaintId = '200201820200101080076610000'; // 替换为实际的投诉单号
    // $detailResult = $complaint->get($complaintId);
    // Tools::pushFile('complaint_detail_result.json', json_encode($detailResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    // echo "查询投诉单详情成功:\n";
    // print_r($detailResult);

    // 3. 创建投诉通知回调地址
    $callbackData = [
        'url' => 'https://yourdomain.com/complaint-notify'
    ];
    $createCallbackResult = $complaint->createCallback($callbackData);
    Tools::pushFile('complaint_create_callback_result.json', json_encode($createCallbackResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "创建投诉通知回调地址成功:\n";
    print_r($createCallbackResult);

    // 4. 查询投诉通知回调地址
    $getCallbackResult = $complaint->getCallback();
    Tools::pushFile('complaint_get_callback_result.json', json_encode($getCallbackResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "查询投诉通知回调地址成功:\n";
    print_r($getCallbackResult);

    // 5. 更新投诉通知回调地址
    $updateCallbackData = [
        'url' => 'https://yourdomain.com/complaint-notify-update'
    ];
    $updateCallbackResult = $complaint->updateCallback($updateCallbackData);
    Tools::pushFile('complaint_update_callback_result.json', json_encode($updateCallbackResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "更新投诉通知回调地址成功:\n";
    print_r($updateCallbackResult);

    // 6. 删除投诉通知回调地址
    $deleteCallbackResult = $complaint->deleteCallback();
    Tools::pushFile('complaint_delete_callback_result.json', json_encode($deleteCallbackResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "删除投诉通知回调地址成功:\n";
    print_r($deleteCallbackResult);

} catch (Exception $e) {
    echo "消费者投诉操作失败: " . $e->getMessage() . "\n";
}