<?php

use AliPay\ZhimaCreditEpSceneAgreement;
use WeChat\Contracts\Tools;

include '../include.php';

// 配置参数
$config = [
    'appid' => 'your_app_id',
    'public_key' => 'your_public_key',
    'private_key' => 'your_private_key',
    'debug' => true, // 沙箱模式
];

// 创建芝麻免押订单测试
function testCreateAgreement()
{
    global $config;
    
    try {
        $agreement = new ZhimaCreditEpSceneAgreement($config);
        
        // 构造创建免押订单参数
        $options = [
            'credit_order_no' => date('YmdHis') . rand(1000, 9999),
            'product_code' => 'w1010100100000000000',
            'subject' => '测试免押商品',
            'amount' => '0.01',
            'seller_id' => '2088102146222222',
            'timeout_express' => '90m',
            'body' => '测试免押商品描述',
            'goods_type' => '1',
            'passback_params' => 'merchantBizType%3d3C%26merchantBizNo%3d2016010101111',
            'promo_params' => '{"promoParam":"value"}',
            'extend_params' => [
                'sys_service_provider_id' => '2088102146222222'
            ],
            'enable_pay_channels' => 'balance,moneyFund,debitCardExpress',
            'disable_pay_channels' => '',
            'store_id' => 'NJ_001',
            'settle_info' => [
                'settle_detail_infos' => [
                    [
                        'trans_in_type' => 'userId',
                        'trans_in' => '2088102146222222',
                        'amount' => '0.01',
                        'summary_digest' => '分账测试',
                    ]
                ]
            ]
        ];
        
        $result = $agreement->create($options);
        Tools::pushFile('zhima_agreement_create_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "创建芝麻免押订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "创建芝麻免押订单失败: " . $e->getMessage() . "\n";
    }
}

// 查询芝麻免押订单测试
function testQueryAgreement()
{
    global $config;
    
    try {
        $agreement = new ZhimaCreditEpSceneAgreement($config);
        
        // 使用之前创建的订单号查询
        $creditOrderNo = '2023040112345678'; // 替换为实际的订单号
        
        $result = $agreement->query($creditOrderNo);
        Tools::pushFile('zhima_agreement_query_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "查询芝麻免押订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "查询芝麻免押订单失败: " . $e->getMessage() . "\n";
    }
}

// 取消芝麻免押订单测试
function testCancelAgreement()
{
    global $config;
    
    try {
        $agreement = new ZhimaCreditEpSceneAgreement($config);
        
        // 构造取消订单参数
        $options = [
            'credit_order_no' => '2023040112345678', // 替换为实际的订单号
            'cancel_reason' => '用户取消',
            'remark' => '用户主动取消订单'
        ];
        
        $result = $agreement->cancel($options);
        Tools::pushFile('zhima_agreement_cancel_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "取消芝麻免押订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "取消芝麻免押订单失败: " . $e->getMessage() . "\n";
    }
}

// 完结芝麻免押订单测试
function testCompleteAgreement()
{
    global $config;
    
    try {
        $agreement = new ZhimaCreditEpSceneAgreement($config);
        
        // 构造完结订单参数
        $options = [
            'credit_order_no' => '2023040112345678', // 替换为实际的订单号
            'complete_amount' => '0.01',
            'complete_time' => date('Y-m-d H:i:s'),
            'remark' => '订单已完结'
        ];
        
        $result = $agreement->complete($options);
        Tools::pushFile('zhima_agreement_complete_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "完结芝麻免押订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "完结芝麻免押订单失败: " . $e->getMessage() . "\n";
    }
}

// 解冻芝麻免押订单测试
function testUnfreezeAgreement()
{
    global $config;
    
    try {
        $agreement = new ZhimaCreditEpSceneAgreement($config);
        
        // 构造解冻订单参数
        $options = [
            'credit_order_no' => '2023040112345678', // 替换为实际的订单号
            'unfreeze_amount' => '0.01',
            'unfreeze_time' => date('Y-m-d H:i:s'),
            'remark' => '订单已解冻'
        ];
        
        $result = $agreement->unfreeze($options);
        Tools::pushFile('zhima_agreement_unfreeze_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "解冻芝麻免押订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "解冻芝麻免押订单失败: " . $e->getMessage() . "\n";
    }
}

// 运行测试
echo "开始测试支付宝芝麻免押V3接口...\n";

// 测试创建订单
testCreateAgreement();

// 测试查询订单
testQueryAgreement();

// 测试取消订单
testCancelAgreement();

// 测试完结订单
testCompleteAgreement();

// 测试解冻订单
testUnfreezeAgreement();

echo "支付宝芝麻免押V3接口测试完成。\n";