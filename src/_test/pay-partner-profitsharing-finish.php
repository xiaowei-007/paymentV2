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

// 2. 创建微信服务商分账对象
$profitSharing = \We::WePayPartnerProfitSharing($config);
// $profitSharing = new \WePayPartner\ProfitSharing($config);

// 3. 组装参数，可以参考官方商户文档
$options = [
    'sub_mchid' => $config['mch_id'],
    'transaction_id' => '微信支付订单号',
    'out_order_no' => time(),
    'description' => '分账完结描述'
];

try {
    // 4. 调用完结分账接口
    $result = $profitSharing->finish($options);
    
    // 5. 输出结果
    echo '<pre>';
    var_export($result);
    
} catch (Exception $e) {
    // 6. 出错处理
    echo $e->getMessage() . PHP_EOL;
}