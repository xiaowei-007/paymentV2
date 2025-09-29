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
    // 创建下载账单对象
    $bill = \We::WePayPartnerBill($config);
    // $bill = new \WePayPartner\Bill($config);

    // 申请交易账单示例
    $tradeBill = $bill->tradeBill('2023-01-01', [
        'sub_mchid' => '1600000000',  // 可选，指定子商户号
        'bill_type' => 'ALL',         // 可选，账单类型 ALL|SUCCESS|REFUND
        'tar_type' => 'GZIP'          // 可选，压缩类型 GZIP
    ]);
    
    Tools::pushFile('bill_trade_bill_result.json', json_encode($tradeBill, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "申请交易账单成功:\n";
    print_r($tradeBill);

    // 申请资金账单示例
    $fundFlowBill = $bill->fundFlowBill('2023-01-01', [
        'account_type' => 'BASIC',    // 可选，资金账户类型 BASIC|OPERATION|FEES
        'tar_type' => 'GZIP'          // 可选，压缩类型 GZIP
    ]);
    
    Tools::pushFile('bill_fund_flow_bill_result.json', json_encode($fundFlowBill, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "申请资金账单成功:\n";
    print_r($fundFlowBill);

    // 如果获取到了下载链接，可以下载账单文件
    if (isset($tradeBill['download_url'])) {
        $downloadPath = __DIR__ . '/downloaded_trade_bill.csv';
        $success = $bill->download($tradeBill['download_url'], $downloadPath, [
            'tar_type' => 'GZIP'  // 如果是压缩文件需要指定
        ]);
        
        if ($success) {
            echo "交易账单文件下载成功，保存路径: {$downloadPath}\n";
        } else {
            echo "交易账单文件下载失败\n";
        }
    }

} catch (Exception $e) {
    echo "下载账单操作失败: " . $e->getMessage() . "\n";
}