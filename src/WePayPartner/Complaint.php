<?php

namespace WePayPartner;

use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidDecryptException;
use WeChat\Exceptions\InvalidResponseException;
use WePayV3\Contracts\DecryptAes;
use WePayPartner\Contracts\BasicWePay;

/**
 * 服务商 | 消费者投诉接口
 * Class Complaint
 * @package WePayPartner
 */
class Complaint extends BasicWePay
{

    /**
     * 查询投诉单列表
     * @param array $params 查询参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012691285
     */
    public function list(array $params)
    {
        $path = '/v3/merchant-service/complaints-v2?' . http_build_query($params);
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 查询投诉单详情
     * @param string $complaintId 投诉单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012691648
     */
    public function get($complaintId)
    {
        $path = "/v3/merchant-service/complaints-v2/{$complaintId}";
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 回复用户
     * @param string $complaintId 投诉单号
     * @param array $data 回复参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012467254
     */
    public function response($complaintId, array $data)
    {
        $path = "/v3/merchant-service/complaints-v2/{$complaintId}/response";
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 反馈处理完成
     * @param string $complaintId 投诉单号
     * @param array $data 参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/docs/partner/apis/consumer-complaint/complaints/complete-complaint-v2.html
     */
    public function complete($complaintId, array $data)
    {
        $path = "/v3/merchant-service/complaints-v2/{$complaintId}/complete";
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 创建投诉通知回调地址
     * @param array $data 回调地址参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012458106
     */
    public function createCallback(array $data)
    {
        $path = '/v3/merchant-service/complaint-notifications';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询投诉通知回调地址
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012459014
     */
    public function getCallback()
    {
        $path = '/v3/merchant-service/complaint-notifications';
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 更新投诉通知回调地址
     * @param array $data 回调地址参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012459282
     */
    public function updateCallback(array $data)
    {
        $path = '/v3/merchant-service/complaint-notifications';
        return $this->doRequest('PUT', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 删除投诉通知回调地址
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012460474
     */
    public function deleteCallback()
    {
        $path = '/v3/merchant-service/complaint-notifications';
        return $this->doRequest('DELETE', $path, '', true);
    }

    /**
     * 投诉通知回调解析
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