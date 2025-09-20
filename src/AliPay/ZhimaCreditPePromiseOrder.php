<?php

namespace AliPay;

use WeChat\Contracts\BasicAliPay;

/**
 * 支付宝芝麻先享V3版本接口
 * Class ZhimaCreditPePromiseOrder
 * @package AliPay
 */
class ZhimaCreditPePromiseOrder extends BasicAliPay
{

    /**
     * 创建芝麻先享订单
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function create($options = [])
    {
        $this->options->set('method', 'zhima.credit.pe.promise.order.create');
        return $this->getResult($options);
    }

    /**
     * 芝麻先享订单状态查询
     * @param string $outOrderNo 商户订单号
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function query($outOrderNo = '')
    {
        $this->options->set('method', 'zhima.credit.pe.promise.order.query');
        return $this->getResult(['out_order_no' => $outOrderNo]);
    }

    /**
     * 芝麻先享订单关闭
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function close($options = [])
    {
        $this->options->set('method', 'zhima.credit.pe.promise.order.close');
        return $this->getResult($options);
    }

    /**
     * 芝麻先享订单履约
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function fulfill($options = [])
    {
        $this->options->set('method', 'zhima.credit.pe.promise.order.fulfill');
        return $this->getResult($options);
    }

    /**
     * 芝麻先享订单取消
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function cancel($options = [])
    {
        $this->options->set('method', 'zhima.credit.pe.promise.order.cancel');
        return $this->getResult($options);
    }

    /**
     * 执行接口操作
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function apply($options = [])
    {
        return $this->getResult($options);
    }
}