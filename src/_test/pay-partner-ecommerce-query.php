<?php

// +----------------------------------------------------------------------
// | PaymentV2
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/WeChatDeveloper
// | github 代码仓库：https://github.com/zoujingli/WeChatDeveloper
// +----------------------------------------------------------------------

include '../include.php';

// 1. 手动加载配置参数
$config = include 'pay-partner-config.php';

// 2. 创建微信服务商特约商户进件对象
$ecommerce = \We::WePayPartnerEcommerce($config);
// $ecommerce = new \WePayPartner\Ecommerce($config);

try {
    // 3. 通过申请单ID查询申请单状态
    $applyment_id = '申请单ID';
    $result = $ecommerce->queryByApplymentId($applyment_id);
    
    // 4. 输出结果
    echo '<pre>';
    var_export($result);
    
} catch (Exception $e) {
    // 5. 出错处理
    echo $e->getMessage() . PHP_EOL;
}