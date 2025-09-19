<?php

namespace WePayPartner;

use WeChat\Exceptions\InvalidResponseException;
use WePayPartner\Contracts\BasicWePay;

/**
 * 服务商 | 特约商户进件接口
 * Class Ecommerce
 * @package WePayPartner
 */
class Ecommerce extends BasicWePay
{

    /**
     * 提交申请单
     * @param array $data 申请单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012062365
     */
    public function apply(array $data)
    {
        $path = '/v3/applyment4sub/applyment/';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询申请单状态
     * @param string $applymentId 申请单ID
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012062365
     */
    public function queryByApplymentId($applymentId)
    {
        $path = "/v3/applyment4sub/applyment/applyment_id/{$applymentId}";
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 通过业务申请编号查询申请单状态
     * @param string $businessCode 业务申请编号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012062365
     */
    public function queryByBusinessCode($businessCode)
    {
        $path = "/v3/applyment4sub/applyment/business_code/{$businessCode}";
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 修改结算账号
     * @param string $subMchid 特约商户号
     * @param array $data 结算账号参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012062365
     */
    public function modifySettlement($subMchid, array $data)
    {
        $path = "/v3/apply4sub/sub_merchants/{$subMchid}/modify-settlement";
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询结算账号
     * @param string $subMchid 特约商户号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012062365
     */
    public function querySettlement($subMchid)
    {
        $path = "/v3/apply4sub/sub_merchants/{$subMchid}/settlement";
        return $this->doRequest('GET', $path, '', true);
    }
}