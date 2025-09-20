<?php

namespace AliPay;

use WeChat\Contracts\BasicAliPay;

/**
 * 支付宝芝麻免押V3版本接口
 * Class ZhimaCreditEpSceneAgreement
 * @package AliPay
 */
class ZhimaCreditEpSceneAgreement extends BasicAliPay
{

    /**
     * 芝麻免押订单创建
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function create($options = [])
    {
        $this->options->set('method', 'zhima.credit.ep.scene.agreement.create');
        return $this->getResult($options);
    }

    /**
     * 芝麻免押订单查询
     * @param string $creditOrderNo 信用订单号
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function query($creditOrderNo = '')
    {
        $this->options->set('method', 'zhima.credit.ep.scene.agreement.query');
        return $this->getResult(['credit_order_no' => $creditOrderNo]);
    }

    /**
     * 芝麻免押订单取消
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function cancel($options = [])
    {
        $this->options->set('method', 'zhima.credit.ep.scene.agreement.cancel');
        return $this->getResult($options);
    }

    /**
     * 芝麻免押订单完结
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function complete($options = [])
    {
        $this->options->set('method', 'zhima.credit.ep.scene.agreement.complete');
        return $this->getResult($options);
    }

    /**
     * 芝麻免押订单解冻
     * @param array $options
     * @return array|boolean
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function unfreeze($options = [])
    {
        $this->options->set('method', 'zhima.credit.ep.scene.agreement.unfreeze');
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