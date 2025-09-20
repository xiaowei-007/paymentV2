<?php

include '../include.php';

// 1. 手动加载配置参数
$config = include 'config.php';

// 2. 创建支付宝芝麻先享对象
$zhima = \We::AliPayZhimaCreditPePromiseOrder($config);
// $zhima = new \AliPay\ZhimaCreditPePromiseOrder($config);

// 3. 组装参数，可以参考官方文档
$options = [
    'out_order_no' => time(),
    'product_code' => 'w1010100100000000000',
    'subject' => '测试商品',
    'amount' => '0.01',
    'seller_id' => '2088102146222222',
    'timeout_express' => '90m',
    'body' => '测试商品描述'
];

try {
    // 4. 调用芝麻先享页面签约接口
    $result = $zhima->create($options);
    
    // 5. 输出结果
    echo $result;
    
} catch (Exception $e) {
    // 6. 出错处理
    echo $e->getMessage() . PHP_EOL;
}