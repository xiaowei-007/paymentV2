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
    // 创建商户平台处置通知对象
    $violation = \We::WePayPartnerViolation($config);
    // $violation = new \WePayPartner\Violation($config);

    // 1. 创建商户违规通知回调地址
    $callbackData = [
        'notify_url' => 'https://yourdomain.com/violation-notify'
    ];
    $createResult = $violation->createCallback($callbackData);
    Tools::pushFile('violation_create_callback_result.json', json_encode($createResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "创建商户违规通知回调地址成功:\n";
    print_r($createResult);

    // 2. 查询商户违规通知回调地址
    $queryResult = $violation->getCallback();
    Tools::pushFile('violation_get_callback_result.json', json_encode($queryResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "查询商户违规通知回调地址成功:\n";
    print_r($queryResult);

    // 3. 更新商户违规通知回调地址
    $updateData = [
        'notify_url' => 'https://yourdomain.com/violation-notify-update'
    ];
    $updateResult = $violation->updateCallback($updateData);
    Tools::pushFile('violation_update_callback_result.json', json_encode($updateResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "更新商户违规通知回调地址成功:\n";
    print_r($updateResult);

    // 4. 查询商户违规记录
    if (isset($config['mch_id'])) {
        $violations = $violation->getViolations($config['mch_id'], [
            'limit' => 10,
            'offset' => 0
        ]);
        Tools::pushFile('violation_get_violations_result.json', json_encode($violations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "查询商户违规记录成功:\n";
        print_r($violations);
    }

    // 5. 删除商户违规通知回调地址
    $deleteResult = $violation->deleteCallback();
    Tools::pushFile('violation_delete_callback_result.json', json_encode($deleteResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "删除商户违规通知回调地址成功:\n";
    print_r($deleteResult);

} catch (Exception $e) {
    echo "商户平台处置通知操作失败: " . $e->getMessage() . "\n";
}