<?php

include '../include.php';

// 1. 手动加载配置参数
$config = include 'pay-partner-config.php';

// 2. 创建微信服务商转账对象
$transfers = \We::WePayPartnerTransfers($config);
// $transfers = new \WePayPartner\Transfers($config);

// 3. 组装参数，可以参考官方商户文档
$options = [
    'sp_appid' => $config['sp_appid'],
    'sp_mchid' => $config['sp_mchid'],
    'sub_mchid' => $config['mch_id'],
    'out_batch_no' => time(),
    'batch_name' => '转账测试',
    'batch_remark' => '转账测试',
    'total_amount' => 1,
    'total_num' => 1,
    'transfer_detail_list' => [
        [
            'out_detail_no' => time() . '1',
            'transfer_amount' => 1,
            'transfer_remark' => '转账测试',
            'openid' => 'o38gpszoJoC9oJYz3UHHf6bEp0Lo'
        ]
    ],
    'notify_url' => 'http://a.com/text.html'
];

try {
    // 4. 调用转账接口
    $result = $transfers->create($options);
    
    // 5. 输出结果
    echo '<pre>';
    var_export($result);
    
} catch (Exception $e) {
    // 6. 出错处理
    echo $e->getMessage() . PHP_EOL;
}