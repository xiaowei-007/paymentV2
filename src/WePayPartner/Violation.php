<?php

namespace WePayPartner;

use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidDecryptException;
use WeChat\Exceptions\InvalidResponseException;
use WePayV3\Contracts\DecryptAes;
use WePayPartner\Contracts\BasicWePay;

/**
 * 服务商 | 商户平台处置通知接口
 * Class Violation
 * @package WePayPartner
 */
class Violation extends BasicWePay
{

    /**
     * 创建商户违规通知回调地址
     * @param array $data 回调地址参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064844
     */
    public function createCallback(array $data)
    {
        $path = '/v3/merchant-risk-manage/violation-notifications';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询商户违规通知回调地址
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064844
     */
    public function getCallback()
    {
        $path = '/v3/merchant-risk-manage/violation-notifications';
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 更新商户违规通知回调地址
     * @param array $data 回调地址参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064844
     */
    public function updateCallback(array $data)
    {
        $path = '/v3/merchant-risk-manage/violation-notifications';
        return $this->doRequest('PUT', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 删除商户违规通知回调地址
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064844
     */
    public function deleteCallback()
    {
        $path = '/v3/merchant-risk-manage/violation-notifications';
        return $this->doRequest('DELETE', $path, '', true);
    }

    /**
     * 查询商户违规记录
     * @param string $subMchid 特约商户号
     * @param array $params 查询参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012064844
     */
    public function getViolations($subMchid, array $params = [])
    {
        $params['sub_mchid'] = $subMchid;
        $path = '/v3/merchant-risk-manage/risk-results?' . http_build_query($params);
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 商户平台处置通知解析
     * @param array|null $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidDecryptException
     */
    public function notify($data = [])
    {
        if (empty($data)) {
            $data = json_decode(Tools::getRawInput(), true);
        }
        if (isset($data['resource'])) {
            $aes = new DecryptAes($this->config['mch_v3_key']);
            $data['result'] = $aes->decryptToString(
                $data['resource']['associated_data'],
                $data['resource']['nonce'],
                $data['resource']['ciphertext']
            );
        }
        return $data;
    }
}