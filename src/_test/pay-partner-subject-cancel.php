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
    // 创建商户开户意愿确认对象
    $subject = \We::WePayPartnerSubject($config);
    // $subject = new \WePayPartner\Subject($config);

    // 撤销商户开户意愿申请单示例（通过申请单号）
    $applymentId = '20000011111'; // 替换为实际的申请单号
    $result = $subject->cancelApplyment(['applyment_id' => $applymentId]);
    Tools::pushFile('subject_cancel_by_applyment_id_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "撤销商户开户意愿申请单（通过申请单号）成功:\n";
    print_r($result);

    // 撤销商户开户意愿申请单示例（通过业务申请编号）
    $businessCode = '1900013511_10000'; // 替换为实际的业务申请编号
    $result2 = $subject->cancelApplyment(['business_code' => $businessCode]);
    Tools::pushFile('subject_cancel_by_business_code_result.json', json_encode($result2, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "撤销商户开户意愿申请单（通过业务申请编号）成功:\n";
    print_r($result2);

    // 撤销商户开户意愿申请单示例（通过业务申请编号和申请单号）
    $result3 = $subject->cancelApplyment([
        'business_code' => $businessCode,
        'applyment_id' => $applymentId
    ]);
    Tools::pushFile('subject_cancel_by_both_result.json', json_encode($result3, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "撤销商户开户意愿申请单（通过业务申请编号和申请单号）成功:\n";
    print_r($result3);

} catch (Exception $e) {
    echo "商户开户意愿确认操作失败: " . $e->getMessage() . "\n";
}