<?php

use AliPay\ZhimaCreditPePromiseOrder;
use WeChat\Contracts\Tools;

include '../include.php';

// 配置参数
$config = [
    'appid' => 'your_app_id',
    'public_key' => 'your_public_key',
    'private_key' => 'your_private_key',
    'debug' => true, // 沙箱模式
];

// 创建芝麻先享订单测试
function testCreateOrder()
{
    global $config;
    
    try {
        $order = new ZhimaCreditPePromiseOrder($config);
        
        // 构造创建订单参数
        $options = [
            'out_order_no' => date('YmdHis') . rand(1000, 9999),
            'product_code' => 'w1010100100000000000',
            'subject' => '测试商品',
            'amount' => '0.01',
            'seller_id' => '2088102146222222',
            'timeout_express' => '90m',
            'body' => '测试商品描述',
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
        
        $result = $order->create($options);
        Tools::pushFile('zhima_create_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "创建芝麻先享订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "创建芝麻先享订单失败: " . $e->getMessage() . "\n";
    }
}

// 查询芝麻先享订单测试
function testQueryOrder()
{
    global $config;
    
    try {
        $order = new ZhimaCreditPePromiseOrder($config);
        
        // 使用之前创建的订单号查询
        $outOrderNo = '2023040112345678'; // 替换为实际的订单号
        
        $result = $order->query($outOrderNo);
        Tools::pushFile('zhima_query_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "查询芝麻先享订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "查询芝麻先享订单失败: " . $e->getMessage() . "\n";
    }
}

// 关闭芝麻先享订单测试
function testCloseOrder()
{
    global $config;
    
    try {
        $order = new ZhimaCreditPePromiseOrder($config);
        
        // 构造关闭订单参数
        $options = [
            'out_order_no' => '2023040112345678', // 替换为实际的订单号
            'close_reason' => '用户取消',
            'remark' => '用户主动取消订单'
        ];
        
        $result = $order->close($options);
        Tools::pushFile('zhima_close_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "关闭芝麻先享订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "关闭芝麻先享订单失败: " . $e->getMessage() . "\n";
    }
}

// 履约芝麻先享订单测试
function testFulfillOrder()
{
    global $config;
    
    try {
        $order = new ZhimaCreditPePromiseOrder($config);
        
        // 构造履约订单参数
        $options = [
            'out_order_no' => '2023040112345678', // 替换为实际的订单号
            'fulfillment_id' => 'fulfill_' . date('YmdHis'),
            'fulfillment_time' => date('Y-m-d H:i:s'),
            'fulfillment_amount' => '0.01',
            'out_content' => '履约内容描述',
            'content' => '履约详情'
        ];
        
        $result = $order->fulfill($options);
        Tools::pushFile('zhima_fulfill_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "履约芝麻先享订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "履约芝麻先享订单失败: " . $e->getMessage() . "\n";
    }
}

// 取消芝麻先享订单测试
function testCancelOrder()
{
    global $config;
    
    try {
        $order = new ZhimaCreditPePromiseOrder($config);
        
        // 构造取消订单参数
        $options = [
            'out_order_no' => '2023040112345678', // 替换为实际的订单号
            'cancel_reason' => '用户取消',
            'remark' => '用户主动取消订单'
        ];
        
        $result = $order->cancel($options);
        Tools::pushFile('zhima_cancel_result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        echo "取消芝麻先享订单成功:\n";
        print_r($result);
        
    } catch (Exception $e) {
        echo "取消芝麻先享订单失败: " . $e->getMessage() . "\n";
    }
}

// 运行测试
echo "开始测试支付宝芝麻先享V3接口...\n";

// 测试创建订单
testCreateOrder();

// 测试查询订单
testQueryOrder();

// 测试关闭订单
testCloseOrder();

// 测试履约订单
testFulfillOrder();

// 测试取消订单
testCancelOrder();

echo "支付宝芝麻先享V3接口测试完成。\n";