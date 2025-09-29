<?php

namespace WePayV3;

use WeChat\Exceptions\InvalidResponseException;
use WePayV3\Contracts\BasicWePay;

/**
 * 直连商户 | 支付分停车服务接口
 * Class Parking
 * @package WePayV3
 */
class Parking extends BasicWePay
{

    /**
     * 创建停车入场
     * @param array $data 停车入场参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012077223
     */
    public function create(array $data)
    {
        $path = '/v3/parking/parkings';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 扣费受理
     * @param array $data 扣费受理参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012077223
     */
    public function pay(array $data)
    {
        $path = '/v3/parking/transactions';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询订单
     * @param string $outTradeNo 商户订单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/merchant/4012077223
     */
    public function query($outTradeNo)
    {
        $pathinfo = "/v3/parking/transactions/out-trade-no/{$outTradeNo}";
        $params = [
            'mchid' => $this->config['mch_id']
        ];
        return $this->doRequest('GET', "{$pathinfo}?" . http_build_query($params), '', true);
    }
}