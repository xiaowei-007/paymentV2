<?php

namespace WePayPartner;

use WeChat\Contracts\Tools;
use WeChat\Exceptions\InvalidArgumentException;
use WeChat\Exceptions\InvalidResponseException;
use WePayPartner\Contracts\BasicWePay;
use WePayV3\Contracts\DecryptAes;

/**
 * 服务商 | 订单支付接口
 * Class Order
 * @package WePayPartner
 * 
 * @method array create(string $type, array $data) 创建支付订单
 * @method array query(string $tradeNo) 查询支付订单
 * @method array close(string $tradeNo) 关闭支付订单
 * @method array notify(array $data = []) 处理支付通知
 * @method array createRefund(array $data) 创建退款订单
 * @method array queryRefund(string $refundNo) 查询退款订单
 * @method array tradeBill(array|string $params) 申请交易账单
 * @method array fundflowBill(array|string $params) 申请资金账单
 * @method string downloadBill(string $fileurl) 下载账单文件
 */
class Order extends BasicWePay
{
    const WXPAY_H5 = 'h5';
    const WXPAY_APP = 'app';
    const WXPAY_JSAPI = 'jsapi';
    const WXPAY_NATIVE = 'native';

    /**
     * 创建支付订单
     * @param string $type 支付类型 (h5, app, jsapi, native)
     * @param array $data 支付参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012069852
     */
    public function create($type, $data)
    {
        $types = [
            'h5'     => '/v3/pay/partner/transactions/h5',
            'app'    => '/v3/pay/partner/transactions/app',
            'jsapi'  => '/v3/pay/partner/transactions/jsapi',
            'native' => '/v3/pay/partner/transactions/native',
        ];
        if (empty($types[$type])) {
            throw new InvalidArgumentException("Payment {$type} not defined.");
        } else {
            // 创建预支付码
            $result = $this->doRequest('POST', $types[$type], json_encode($data, JSON_UNESCAPED_UNICODE), true);
            if (empty($result['h5_url']) && empty($result['code_url']) && empty($result['prepay_id'])) {
                $message = isset($result['code']) ? "[ {$result['code']} ] " : '';
                $message .= isset($result['message']) ? $result['message'] : json_encode($result, JSON_UNESCAPED_UNICODE);
                throw new InvalidResponseException($message);
            }
            // 支付参数签名
            $time = strval(time());
            $appid = $this->config['appid'];
            $nonceStr = Tools::createNoncestr();
            if ($type === 'app') {
                $sign = $this->signBuild(join("\n", [$appid, $time, $nonceStr, $result['prepay_id'], '']));
                return ['partnerId' => $this->config['mch_id'], 'prepayId' => $result['prepay_id'], 'package' => 'Sign=WXPay', 'nonceStr' => $nonceStr, 'timeStamp' => $time, 'sign' => $sign];
            } elseif ($type === 'jsapi') {
                $sign = $this->signBuild(join("\n", [$appid, $time, $nonceStr, "prepay_id={$result['prepay_id']}", '']));
                return ['appId' => $appid, 'timestamp' => $time, 'timeStamp' => $time, 'nonceStr' => $nonceStr, 'package' => "prepay_id={$result['prepay_id']}", 'signType' => 'RSA', 'paySign' => $sign];
            } else {
                return $result;
            }
        }
    }

    /**
     * 支付订单查询
     * @param string $tradeNo 订单单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012069852
     */
    public function query($tradeNo)
    {
        $pathinfo = "/v3/pay/partner/transactions/out-trade-no/{$tradeNo}";
        $params = [
            'sp_mchid' => $this->config['sp_mchid'],
            'mchid' => $this->config['mch_id']
        ];
        return $this->doRequest('GET', "{$pathinfo}?" . http_build_query($params), '', true);
    }

    /**
     * 关闭支付订单
     * @param string $tradeNo 订单单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function close($tradeNo)
    {
        $data = [
            'sp_mchid' => $this->config['sp_mchid'],
            'mchid' => $this->config['mch_id']
        ];
        $path = "/v3/pay/partner/transactions/out-trade-no/{$tradeNo}/close";
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 支付通知解析
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

    /**
     * 创建退款订单
     * @param array $data 退款参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4013080622
     */
    public function createRefund($data)
    {
        $path = '/v3/refund/domestic/refunds';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 退款订单查询
     * @param string $refundNo 退款单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4013080622
     */
    public function queryRefund($refundNo)
    {
        $path = "/v3/refund/domestic/refunds/{$refundNo}";
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 获取退款通知
     * @param mixed $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @deprecated 直接使用 Notify 方法
     */
    public function notifyRefund($data = [])
    {
        return $this->notify($data);
    }

    /**
     * 申请交易账单
     * @param array|string $params 账单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012072827
     */
    public function tradeBill($params)
    {
        $path = '/v3/bill/tradebill?' . (is_array($params) ? http_build_query($params) : $params);
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 申请资金账单
     * @param array|string $params 账单参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012072827
     */
    public function fundflowBill($params)
    {
        $path = '/v3/bill/fundflowbill?' . (is_array($params) ? http_build_query($params) : $params);
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 下载账单文件
     * @param string $fileurl 文件URL
     * @return string 二进制 Excel 内容
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4012072827
     */
    public function downloadBill($fileurl)
    {
        return $this->doRequest('GET', $fileurl, '', false, false);
    }
}