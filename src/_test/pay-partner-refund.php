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

// 2. 创建微信服务商退款对象
$refund = \We::WePayPartnerRefund($config);
// $refund = new \WePayPartner\Refund($config);

// 3. 组装参数，可以参考官方商户文档
$options = [
    'sp_mchid' => $config['sp_mchid'],
    'sub_mchid' => $config['mch_id'],
    'out_trade_no' => '商户订单号',
    'out_refund_no' => time(),
    'amount' => [
        'refund' => 1,
        'total' => 1,
        'currency' => 'CNY'
    ],
    'reason' => '测试退款'
];

try {
    // 4. 调用退款接口
    $result = $refund->create($options);
    
    // 5. 输出结果
    echo '<pre>';
    var_export($result);
    
} catch (Exception $e) {
    // 6. 出错处理
    echo $e->getMessage() . PHP_EOL;
}