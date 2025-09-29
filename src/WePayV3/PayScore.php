<?php

namespace WePayV3;

use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidResponseException;
use WePayV3\Contracts\BasicWePay;
use WePayV3\Contracts\DecryptAes;

/**
 * 直连商户 | 支付分接口
 * Class PayScore
 * @package WePayV3
 */
class PayScore extends BasicWePay
{

    /**
     * 创建支付分订单
     * @param array $data 支付分订单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012587050
     */
    public function create(array $data)
    {
        $path = '/v3/payscore/serviceorder';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询支付分订单
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012587050
     */
    public function query($outOrderNo, $serviceId)
    {
        $pathinfo = "/v3/payscore/serviceorder";
        $params = [
            'service_id' => $serviceId,
            'out_order_no' => $outOrderNo
        ];
        return $this->doRequest('GET', "{$pathinfo}?" . http_build_query($params), '', true);
    }

    /**
     * 取消支付分订单
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @param string $reason 取消原因
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012587050
     */
    public function cancel($outOrderNo, $serviceId, $reason)
    {
        $path = '/v3/payscore/serviceorder/cancel';
        $data = [
            'service_id' => $serviceId,
            'out_order_no' => $outOrderNo,
            'reason' => $reason
        ];
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 修改支付分订单金额
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @param array $data 修改订单金额参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012587050
     */
    public function modify($outOrderNo, $serviceId, array $data)
    {
        $path = '/v3/payscore/serviceorder/modify';
        $data['service_id'] = $serviceId;
        $data['out_order_no'] = $outOrderNo;
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 完结支付分订单
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @param array $data 完结订单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012587050
     */
    public function complete($outOrderNo, $serviceId, array $data)
    {
        $path = '/v3/payscore/serviceorder/complete';
        $data['service_id'] = $serviceId;
        $data['out_order_no'] = $outOrderNo;
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 同步服务订单
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @param array $data 同步订单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012587050
     */
    public function sync($outOrderNo, $serviceId, array $data)
    {
        $path = '/v3/payscore/serviceorder/sync';
        $data['service_id'] = $serviceId;
        $data['out_order_no'] = $outOrderNo;
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 支付分通知解析
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