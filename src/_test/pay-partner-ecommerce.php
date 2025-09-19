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

// 3. 组装参数，可以参考官方商户文档
$options = [
    'sp_mchid' => $config['sp_mchid'],
    'business_code' => time(),
    'contact_info' => [
        'contact_type' => 'LEGAL',
        'contact_name' => '张三',
        'contact_id_doc_type' => 'IDENTIFICATION_TYPE_IDCARD',
        'contact_id_doc_number' => '110101199003071819',
        'contact_id_doc_address' => '广东省深圳市南山区科技中一路腾讯大厦',
        'contact_id_doc_copy' => 'xxx',
        'contact_id_doc_copy_back' => 'xxx',
        'contact_period_begin' => '2020-01-01',
        'contact_period_end' => '2030-01-01',
        'business_authorization_letter' => 'xxx',
        'contact_id_doc_period_begin' => '2020-01-01',
        'contact_id_doc_period_end' => '2030-01-01'
    ],
    'subject_info' => [
        'subject_type' => 'SUBJECT_TYPE_INDIVIDUAL',
        'business_license_info' => [
            'license_copy' => 'xxx',
            'license_number' => '123456789012345678',
            'merchant_name' => '个体户张三',
            'legal_person' => '张三'
        ],
        'identity_info' => [
            'id_doc_type' => 'IDENTIFICATION_TYPE_IDCARD',
            'id_card_info' => [
                'id_card_copy' => 'xxx',
                'id_card_national' => 'xxx',
                'id_card_name' => '张三',
                'id_card_number' => '110101199003071819',
                'id_card_address' => '广东省深圳市南山区科技中一路腾讯大厦',
                'id_card_period_begin' => '2020-01-01',
                'id_card_period_end' => '2030-01-01'
            ],
            'owner' => true
        ],
        'ubo_info' => [
            'ubo_id_doc_type' => 'IDENTIFICATION_TYPE_IDCARD',
            'ubo_id_card_info' => [
                'ubo_id_card_copy' => 'xxx',
                'ubo_id_card_national' => 'xxx',
                'ubo_id_card_name' => '张三',
                'ubo_id_card_number' => '110101199003071819',
                'ubo_id_card_address' => '广东省深圳市南山区科技中一路腾讯大厦',
                'ubo_period_begin' => '2020-01-01',
                'ubo_period_end' => '2030-01-01'
            ]
        ]
    ],
    'business_info' => [
        'merchant_shortname' => '张三餐饮店',
        'service_phone' => '0755-86013388',
        'sales_info' => [
            'sales_scenes_type' => [
                'SALES_SCENES_STORE',
                'SALES_SCENES_MP'
            ],
            'biz_store_info' => [
                'biz_store_name' => '张三餐饮店',
                'biz_address_code' => '440305',
                'biz_store_address' => '广东省深圳市南山区科技中一路腾讯大厦',
                'store_entrance_pic' => [
                    'xxx'
                ],
                'indoor_pic' => [
                    'xxx'
                ],
                'biz_sub_appid' => 'wxc7b3ec5ced45fccd'
            ],
            'mp_info' => [
                'mp_appid' => 'wxc7b3ec5ced45fccd',
                'mp_sub_appid' => 'wxc7b3ec5ced45fccd',
                'mp_pics' => [
                    'xxx'
                ]
            ]
        ]
    ],
    'settlement_info' => [
        'settlement_id' => '7555',
        'qualification_type' => '餐饮',
        'qualifications' => [
            'xxx'
        ],
        'activities_id' => '123456',
        'activities_rate' => '0.6',
        'activities_additions' => [
            'xxx'
        ]
    ],
    'bank_account_info' => [
        'bank_account_type' => 'BANK_ACCOUNT_TYPE_CORPORATE',
        'account_name' => '张三',
        'account_bank' => '工商银行',
        'bank_address_code' => '440305',
        'bank_name' => '工商银行南山支行',
        'account_number' => '6222000000000000000'
    ]
];

try {
    // 4. 调用提交申请单接口
    $result = $ecommerce->apply($options);
    
    // 5. 输出结果
    echo '<pre>';
    var_export($result);
    
} catch (Exception $e) {
    // 6. 出错处理
    echo $e->getMessage() . PHP_EOL;
}