<?php

namespace WePayPartner;

use WeChat\Exceptions\InvalidResponseException;
use WePayPartner\Contracts\BasicWePay;

/**
 * 服务商 | 商户开户意愿确认接口
 * Class Subject
 * @package WePayPartner
 */
class Subject extends BasicWePay
{

    /**
     * 提交商户开户意愿申请单
     * @param array $data 申请单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064820
     */
    public function apply(array $data)
    {
        $path = '/v3/apply4subject/applyment';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询商户开户意愿申请单状态（通过申请单号）
     * @param string $applymentId 申请单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064820
     */
    public function queryByApplymentId($applymentId)
    {
        $path = "/v3/apply4subject/applyment/applyment_id/{$applymentId}";
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 查询商户开户意愿申请单状态（通过商户号）
     * @param string $subMchid 特约商户号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064820
     */
    public function queryBySubMchid($subMchid)
    {
        $path = "/v3/apply4subject/applyment/sub_mchid/{$subMchid}";
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 获取商户开户意愿确认状态
     * @param string $subMchid 特约商户号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064820
     */
    public function getState($subMchid)
    {
        $path = "/v3/apply4subject/applyment/merchants/{$subMchid}/state";
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 撤销商户开户意愿申请单
     * @param string $applymentId 申请单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064820
     * @deprecated 请使用 cancelApplyment 方法替代
     */
    public function cancel($applymentId)
    {
        $path = "/v3/apply4subject/applyment/{$applymentId}/cancel";
        return $this->doRequest('POST', $path, json_encode([], JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 撤销商户开户意愿申请单（支持通过business_code或applyment_id撤销）
     * @param array $params 撤销参数，包含business_code或applyment_id
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012697627
     */
    public function cancelApplyment(array $params)
    {
        if (isset($params['business_code'])) {
            $path = "/v3/apply4subject/applyment/{$params['business_code']}/cancel";
            $queryParams = [];
            if (isset($params['applyment_id'])) {
                $queryParams['applyment_id'] = $params['applyment_id'];
            }
            if (!empty($queryParams)) {
                $path .= '?' . http_build_query($queryParams);
            }
        } elseif (isset($params['applyment_id'])) {
            $path = "/v3/apply4subject/applyment/{$params['applyment_id']}/cancel";
        } else {
            throw new \WeChat\Exceptions\InvalidArgumentException("Missing required parameter: business_code or applyment_id");
        }
        
        return $this->doRequest('POST', $path, json_encode([], JSON_UNESCAPED_UNICODE), true);
    }
}