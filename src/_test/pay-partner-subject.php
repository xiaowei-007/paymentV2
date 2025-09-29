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

    // 提交商户开户意愿申请单示例
    $applyData = [
        'business_code' => 'business_' . time(),
        'contact_info' => [
            'contact_type' => 'LEGAL_PERSON',
            'contact_name' => '张三',
            'contact_id_card_number' => '11010119900307XXXX',
            'mobile' => '13800138000',
            'email' => 'zhangsan@example.com'
        ],
        'subject_info' => [
            'subject_type' => 'SUBJECT_TYPE_INDIVIDUAL',
            'business_licence_info' => [
                'licence_number' => '9144030076543210XX',
                'merchant_name' => '深圳市某某科技有限公司',
                'company_address' => '深圳市南山区某某街道某某号',
                'legal_person' => '张三'
            ]
        ],
        'notify_url' => 'https://yourdomain.com/notify'
    ];

    $result = $subject->apply($applyData);
    Tools::pushFile('subject_apply_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "提交商户开户意愿申请单成功:\n";
    print_r($result);

    // 查询商户开户意愿申请单状态（通过申请单号）
    if (isset($result['applyment_id'])) {
        $queryResult = $subject->queryByApplymentId($result['applyment_id']);
        Tools::pushFile('subject_query_by_applyment_id_result.json', json_encode($queryResult, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "查询商户开户意愿申请单状态（通过申请单号）成功:\n";
        print_r($queryResult);
    }

    // 查询商户开户意愿申请单状态（通过商户号）
    if (isset($config['mch_id'])) {
        $queryResult2 = $subject->queryBySubMchid($config['mch_id']);
        Tools::pushFile('subject_query_by_sub_mchid_result.json', json_encode($queryResult2, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "查询商户开户意愿申请单状态（通过商户号）成功:\n";
        print_r($queryResult2);
    }

} catch (Exception $e) {
    echo "商户开户意愿确认操作失败: " . $e->getMessage() . "\n";
}