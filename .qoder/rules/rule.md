---
trigger: manual
---
# PaymentV2 项目规则文档

## 1. 项目概述

PaymentV2 是一个基于 PHP 的微信与支付宝支付 SDK 封装库，旨在简化第三方支付接口的调用流程，提升开发效率。适用于需要接入微信和支付宝多种支付方式的 Web 应用或服务端系统。

### 1.1 核心功能
- 微信小程序服务端接口支持
- 微信认证服务号接口支持
- 微信支付功能：JSAPI支付、App支付、扫码支付、Web支付、红包、退款、转账、账单下载等
- 支付宝支付功能：App支付、Wap支付、Web支付、扫码支付、刷卡支付、转账、账单下载等

### 1.2 技术要求
- PHP 版本最低要求 5.4，但 composer.json 中要求 >=7.0，实际推荐 PHP 7+
- 依赖扩展：ext-xml, ext-json, ext-curl, ext-bcmath, ext-libxml, ext-openssl, ext-mbstring, ext-simplexml
- 使用 PSR-4 自动加载规范组织代码

## 2. 项目结构

```
src/
├── AliPay/           # 支付宝支付实现
├── WeChat/           # 微信公众号接口实现
│   ├── Contracts/    # 基础抽象类与工具类
│   └── Exceptions/   # 异常处理类
├── WeMini/           # 微信小程序接口实现
├── WePay/            # 微信商户平台 V2 接口
├── WePayV3/          # 微信支付 V3 接口支持
└── _test/            # 测试脚本集合
```

## 3. 代码规范

### 3.1 命名规范
- 类名采用大驼峰命名法（PascalCase）
- 方法名采用小驼峰命名法（camelCase）
- 常量名全部大写，单词间用下划线分隔
- 变量名采用小驼峰命名法

### 3.2 注释规范
- 类文件头部必须包含标准注释块，说明类的功能、作者、版权等信息
- 方法必须有注释说明功能、参数、返回值和可能抛出的异常
- 复杂逻辑需要添加行内注释说明

### 3.3 代码风格
- 使用 4 个空格缩进，不使用 Tab
- 每行代码不超过 120 个字符
- 左花括号不换行，右花括号单独一行
- 类属性和方法访问修饰符必须明确声明

## 4. 架构设计

### 4.1 设计模式
- 工厂模式：通过静态方法创建具体类实例
- 单一职责原则：每个类负责一个特定功能模块
- 依赖注入：配置参数通过构造函数传入
- 模板方法模式：基类定义通用流程，子类实现差异逻辑

### 4.2 核心组件
- 入口类：`\We::` 提供静态工厂方法创建各类服务实例
- 基础类：各模块继承对应的基类（BasicWeChat、BasicWePay、BasicAliPay）
- 工具类：`\WeChat\Contracts\Tools` 提供网络请求、数据处理等通用功能
- 异常类：统一的异常处理机制

## 5. 使用方式

### 5.1 初始化配置
```php
$config = [
    'appid'        => 'wx3760xxxxxxxxxxxx',
    'mch_id'       => '15293xxxxxx',
    'mch_key'      => 'c4d5e6f7g8h9i0j1k2l3m4n5o6p7q8r9',
    'cache_path'   => '/tmp/'
];
```

### 5.2 实例化服务
```php
// 微信用户管理
$user = new \WeChat\User($config);
$list = $user->getUserList();

// 支付宝网站支付
$pay = \We::AliPayWeb($config);
$result = $pay->apply([
    'out_trade_no' => time(),
    'total_amount' => '1',
    'subject'      => '支付订单描述'
]);
```

## 6. 缓存机制

项目支持自定义缓存处理机制，默认使用本地文件缓存：
```php
\WeChat\Contracts\Tools::$cache_callable = [
    'set' => function ($name, $value, $expired = 360) {
        // 自定义写入缓存逻辑
    },
    'get' => function ($name) {
        // 自定义获取缓存逻辑
    },
    'del' => function ($name) {
        // 自定义删除缓存逻辑
    },
    'put' => function ($name) {
        // 自定义写入文件逻辑
    }
];
```

## 7. 安全要求

- 商户私钥必须保密，不得暴露在代码中
- 回调通知需验证签名防止伪造
- 敏感数据传输需使用 HTTPS
- 缓存路径不可被 Web 直接访问