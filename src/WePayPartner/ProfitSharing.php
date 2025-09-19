<?php

namespace WePayPartner;

use WeChat\Exceptions\InvalidResponseException;
use WePayPartner\Contracts\BasicWePay;
use WeChat\Contracts\Tools;
use WePayV3\Contracts\DecryptAes;

/**
 * 服务商 | 分账接口
 * Class ProfitSharing
 * @package WePayPartner
 */
class ProfitSharing extends BasicWePay
{

    /**
     * 添加分账接收方
     * @param array $data 分账接收方参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085810
     */
    public function addReceiver(array $data)
    {
        $path = '/v3/profitsharing/receivers/add';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 删除分账接收方
     * @param array $data 分账接收方参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085810
     */
    public function removeReceiver(array $data)
    {
        $path = '/v3/profitsharing/receivers/delete';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 发起分账请求
     * @param array $data 分账参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085810
     */
    public function create(array $data)
    {
        $path = '/v3/profitsharing/orders';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询分账结果
     * @param string $outOrderNo 商户分账单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085810
     */
    public function query($outOrderNo)
    {
        $pathinfo = "/v3/profitsharing/orders/{$outOrderNo}";
        $params = [
            'sp_mchid' => $this->config['sp_mchid'],
            'mchid' => $this->config['mch_id']
        ];
        return $this->doRequest('GET', "{$pathinfo}?" . http_build_query($params), '', true);
    }

    /**
     * 请求分账回退
     * @param array $data 分账回退参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085810
     */
    public function returnOrder(array $data)
    {
        $path = '/v3/profitsharing/return-orders';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询分账回退结果
     * @param string $outOrderNo 商户分账单号
     * @param string $outReturnNo 商户回退单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085810
     */
    public function queryReturn($outOrderNo, $outReturnNo)
    {
        $pathinfo = "/v3/profitsharing/return-orders/{$outReturnNo}";
        $params = [
            'sp_mchid' => $this->config['sp_mchid'],
            'mchid' => $this->config['mch_id'],
            'out_order_no' => $outOrderNo
        ];
        return $this->doRequest('GET', "{$pathinfo}?" . http_build_query($params), '', true);
    }

    /**
     * 完结分账
     * @param array $data 完结分账参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085810
     */
    public function finish(array $data)
    {
        $path = '/v3/profitsharing/finish-order';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 分账回退通知解析
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