<?php

namespace AliPay;

use WeChat\Contracts\BasicAliPay;
use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidResponseException;

class Login extends BasicAliPay
{
    /**
     * Pos constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        parent::__construct($options);
        $this->options->set('method', 'alipay.system.oauth.token');
    }

    /**
     * 重写applyData方法，将grant_type和code直接放在options中，而不是biz_content中
     * @param array $options
     */
    protected function applyData($options)
    {
        // 将grant_type和code直接设置到options中
        if (isset($options['grant_type'])) {
            $this->options->set('grant_type', $options['grant_type']);
        }
        if (isset($options['code'])) {
            $this->options->set('code', $options['code']);
        }
        // 生成签名
        $this->options->set('sign', $this->getSign());
    }

    protected function getResult($options)
    {
        $this->applyData($options);
        $method = str_replace('.', '_', $this->options['method']) . '_response';
        $data = json_decode(Tools::get($this->gateway, $this->options->get()), true);
        if (isset($data[$method]['code'])) {
            throw new InvalidResponseException(
                "Error: " .
                (empty($data[$method]['code']) ? '' : "{$data[$method]['msg']} [{$data[$method]['code']}]\r\n") .
                (empty($data[$method]['sub_code']) ? '' : "{$data[$method]['sub_msg']} [{$data[$method]['sub_code']}]\r\n"),
                $data[$method]['code'], $data
            );
        }
        return $data[$method];
    }

    /**
     * 创建数据操作
     * @param array $options
     * @return array|bool
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function apply($options)
    {
        return $this->getResult($options);
    }

}
