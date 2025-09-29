<?php

// 简单测试文件验证新类是否能正确加载和实例化

include __DIR__ . '/../include.php';

echo "Testing WePayV3 PayScore class...\n";

try {
    // 测试微信支付分类
    $config = [
        'appid' => 'test_appid',
        'mch_id' => 'test_mch_id',
        'mch_v3_key' => 'test_mch_v3_key',
        'cert_public' => 'test_cert_public',
        'cert_private' => 'test_cert_private'
    ];
    
    $payscore = new \WePayV3\PayScore($config);
    echo "WePayV3\\PayScore class instantiated successfully!\n";
    
    // 检查类方法是否存在
    if (method_exists($payscore, 'create')) {
        echo "Method 'create' exists in PayScore class\n";
    }
    
    if (method_exists($payscore, 'query')) {
        echo "Method 'query' exists in PayScore class\n";
    }
    
    if (method_exists($payscore, 'cancel')) {
        echo "Method 'cancel' exists in PayScore class\n";
    }
    
    if (method_exists($payscore, 'modify')) {
        echo "Method 'modify' exists in PayScore class\n";
    }
    
    if (method_exists($payscore, 'complete')) {
        echo "Method 'complete' exists in PayScore class\n";
    }
    
    if (method_exists($payscore, 'sync')) {
        echo "Method 'sync' exists in PayScore class\n";
    }
    
} catch (Exception $e) {
    echo "Error instantiating PayScore: " . $e->getMessage() . "\n";
}

echo "\nTesting WePayV3 Parking class...\n";

try {
    // 测试微信停车服务类
    $parking = new \WePayV3\Parking($config);
    echo "WePayV3\\Parking class instantiated successfully!\n";
    
    // 检查类方法是否存在
    if (method_exists($parking, 'create')) {
        echo "Method 'create' exists in Parking class\n";
    }
    
    if (method_exists($parking, 'pay')) {
        echo "Method 'pay' exists in Parking class\n";
    }
    
    if (method_exists($parking, 'query')) {
        echo "Method 'query' exists in Parking class\n";
    }
    
} catch (Exception $e) {
    echo "Error instantiating Parking: " . $e->getMessage() . "\n";
}

echo "\nAll tests completed!\n";