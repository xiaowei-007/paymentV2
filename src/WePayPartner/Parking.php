<?php

namespace WePayPartner;

use WeChat\Exceptions\InvalidResponseException;
use WePayPartner\Contracts\BasicWePay;

/**
 * 服务商 | 支付分停车服务接口
 * Class Parking
 * @package WePayPartner
 */
class Parking extends BasicWePay
{

    /**
     * 创建停车入场
     * @param array $data 停车入场参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085549
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
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085549
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
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012085549
     */
    public function query($outTradeNo)
    {
        $pathinfo = "/v3/parking/transactions/out-trade-no/{$outTradeNo}";
        $params = [
            'sp_mchid' => $this->config['sp_mchid'],
            'mchid' => $this->config['mch_id']
        ];
        return $this->doRequest('GET', "{$pathinfo}?" . http_build_query($params), '', true);
    }
}