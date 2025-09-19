<?php

// +----------------------------------------------------------------------
// | PaymentV2
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/WeChatDeveloper
// | github 代码仓库：https://github.com/zoujingli/WeChatDeveloper
// +----------------------------------------------------------------------

namespace WePayPartner;

use WeChat\Exceptions\InvalidResponseException;
use WePayPartner\Contracts\BasicWePay;
use WeChat\Contracts\Tools;
use WePayV3\Contracts\DecryptAes;

/**
 * 服务商 | 支付分接口
 * Class PayScore
 * @package WePayPartner
 */
class PayScore extends BasicWePay
{

    /**
     * 创建支付分订单
     * @param array $data 支付分订单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012586132
     */
    public function create(array $data)
    {
        $path = '/v3/payscore/partner/serviceorder';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询支付分订单
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @param string $subMchid 子商户号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012586132
     */
    public function query($outOrderNo, $serviceId, $subMchid)
    {
        $pathinfo = "/v3/payscore/partner/serviceorder";
        $params = [
            'service_id' => $serviceId,
            'out_order_no' => $outOrderNo,
            'sub_mchid' => $subMchid
        ];
        return $this->doRequest('GET', "{$pathinfo}?" . http_build_query($params), '', true);
    }

    /**
     * 取消支付分订单
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @param string $subMchid 子商户号
     * @param string $reason 取消原因
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012586132
     */
    public function cancel($outOrderNo, $serviceId, $subMchid, $reason)
    {
        $path = '/v3/payscore/partner/serviceorder/cancel';
        $data = [
            'service_id' => $serviceId,
            'out_order_no' => $outOrderNo,
            'sub_mchid' => $subMchid,
            'reason' => $reason
        ];
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 修改支付分订单金额
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @param string $subMchid 子商户号
     * @param array $data 修改订单金额参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012586132
     */
    public function modify($outOrderNo, $serviceId, $subMchid, array $data)
    {
        $path = '/v3/payscore/partner/serviceorder/modify';
        $data['service_id'] = $serviceId;
        $data['out_order_no'] = $outOrderNo;
        $data['sub_mchid'] = $subMchid;
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 完结支付分订单
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @param string $subMchid 子商户号
     * @param array $data 完结订单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012586132
     */
    public function complete($outOrderNo, $serviceId, $subMchid, array $data)
    {
        $path = '/v3/payscore/partner/serviceorder/complete';
        $data['service_id'] = $serviceId;
        $data['out_order_no'] = $outOrderNo;
        $data['sub_mchid'] = $subMchid;
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 同步服务订单
     * @param string $outOrderNo 商户订单号
     * @param string $serviceId 服务ID
     * @param string $subMchid 子商户号
     * @param array $data 同步订单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012586132
     */
    public function sync($outOrderNo, $serviceId, $subMchid, array $data)
    {
        $path = '/v3/payscore/partner/serviceorder/sync';
        $data['service_id'] = $serviceId;
        $data['out_order_no'] = $outOrderNo;
        $data['sub_mchid'] = $subMchid;
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