<?php

// 简单测试文件验证新类是否能正确加载和实例化

include __DIR__ . '/../include.php';

echo "Testing Zhima Credit Pe Promise Order class...\n";

try {
    // 测试芝麻先享类
    $config = [
        'appid' => 'test_appid',
        'public_key' => 'test_public_key',
        'private_key' => 'test_private_key'
    ];
    
    $zhimaPePromise = new \AliPay\ZhimaCreditPePromiseOrder($config);
    echo "ZhimaCreditPePromiseOrder class instantiated successfully!\n";
    
    // 检查类方法是否存在
    if (method_exists($zhimaPePromise, 'create')) {
        echo "Method 'create' exists in ZhimaCreditPePromiseOrder class\n";
    }
    
    if (method_exists($zhimaPePromise, 'query')) {
        echo "Method 'query' exists in ZhimaCreditPePromiseOrder class\n";
    }
    
    if (method_exists($zhimaPePromise, 'close')) {
        echo "Method 'close' exists in ZhimaCreditPePromiseOrder class\n";
    }
    
    if (method_exists($zhimaPePromise, 'fulfill')) {
        echo "Method 'fulfill' exists in ZhimaCreditPePromiseOrder class\n";
    }
    
    if (method_exists($zhimaPePromise, 'cancel')) {
        echo "Method 'cancel' exists in ZhimaCreditPePromiseOrder class\n";
    }
    
} catch (Exception $e) {
    echo "Error instantiating ZhimaCreditPePromiseOrder: " . $e->getMessage() . "\n";
}

echo "\nTesting Zhima Credit Ep Scene Agreement class...\n";

try {
    // 测试芝麻免押类
    $zhimaEpAgreement = new \AliPay\ZhimaCreditEpSceneAgreement($config);
    echo "ZhimaCreditEpSceneAgreement class instantiated successfully!\n";
    
    // 检查类方法是否存在
    if (method_exists($zhimaEpAgreement, 'create')) {
        echo "Method 'create' exists in ZhimaCreditEpSceneAgreement class\n";
    }
    
    if (method_exists($zhimaEpAgreement, 'query')) {
        echo "Method 'query' exists in ZhimaCreditEpSceneAgreement class\n";
    }
    
    if (method_exists($zhimaEpAgreement, 'cancel')) {
        echo "Method 'cancel' exists in ZhimaCreditEpSceneAgreement class\n";
    }
    
    if (method_exists($zhimaEpAgreement, 'complete')) {
        echo "Method 'complete' exists in ZhimaCreditEpSceneAgreement class\n";
    }
    
    if (method_exists($zhimaEpAgreement, 'unfreeze')) {
        echo "Method 'unfreeze' exists in ZhimaCreditEpSceneAgreement class\n";
    }
    
} catch (Exception $e) {
    echo "Error instantiating ZhimaCreditEpSceneAgreement: " . $e->getMessage() . "\n";
}

echo "\nAll tests completed!\n";