<?php

namespace WePayV3;

use WePayV3\Contracts\BasicWePay;
use WeChat\Exceptions\InvalidResponseException;
use WeChat\Contracts\Tools;
use WePayV3\Contracts\DecryptAes;

/**
 * 普通商户商家转账到零钱
 * @class MchTransfer
 * @package WePayV3
 */
class MchTransfer extends BasicWePay
{
    /**
     * 发起商家批量转账
     * @param array $body
     * @return array
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @link https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter4_3_1.shtml
     */
    public function create(array $options)
    {
        $options['appid'] = $this->config['appid'];
        //【收款用户姓名】 收款方真实姓名。需要加密传入，支持标准RSA算法和国密算法，公钥由微信侧提供
        //金额大于30才要加密
        // if($options['transfer_amount'] > 3){
        //     $options['user_name'] = $this->rsaEncode($options['user_name']);
        // }
        $options['user_name'] = empty($options['user_name']) ? '' : $this->rsaEncode($options['user_name']);
        $result = $this->doRequest('POST', '/v3/fund-app/mch-transfer/transfer-bills', json_encode($options, JSON_UNESCAPED_UNICODE), true);
        if(isset($result['state']) && $result['state'] == 'FAIL'){
            $message = isset($result['code']) ? "[ {$result['code']} ] " : '';
            $message .= isset($result['message']) ? $result['message'] : json_encode($result, JSON_UNESCAPED_UNICODE);
            throw new InvalidResponseException($message);
        }
        return $result;
    }

    /**
     * 撤销转账
     * @param string $out_bill_no 商户系统内部的商家批次单号，在商户系统内部唯一
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function cancelTransfer($out_bill_no)
    {
        return $this->doRequest('POST', "/v3/fund-app/mch-transfer/transfer-bills/out-bill-no/{$out_bill_no}/cancel", '', true);
    }

    /**
     * 通过商家单号查询转账单
     * @param string $out_bill_no 商户系统内部的商家批次单号，在商户系统内部唯一
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function query($out_bill_no)
    {
        $pathinfo = "/v3/fund-app/mch-transfer/transfer-bills/out-bill-no/{$out_bill_no}";
        return $this->doRequest('GET', $pathinfo, '', true);
    }

    /**
     * 通过微信单号查询转账单
     * @param string $transfer_bill_no 微信支付系统内部区分转账批次单下不同转账明细单的唯一标识
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function queryTransferBillNo($transfer_bill_no)
    {
        $pathinfo = "/v3/fund-app/mch-transfer/transfer-bills/transfer-bill-no/{$transfer_bill_no}";
        return $this->doRequest('GET', $pathinfo, '', true);
    }

    /**
     * 支付通知解析
     * @param array $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidDecryptException
     */
    public function notify(array $data = [])
    {
        if (empty($data)) {
            $data = json_decode(Tools::getRawInput(), true);
        }
        // {
        //     "id": "EV-2018022511223320873",
        //     "create_time": "2015-05-20T13:29:35+08:00",
        //     "resource_type": "encrypt-resource",
        //     "event_type": "MCHTRANSFER.BILL.FINISHED",
        //     "summary": "商家转账单据终态通知",
        //     "resource": {
        //         "original_type": "mch_payment",
        //         "algorithm": "AEAD_AES_256_GCM",
        //         "ciphertext":"zTBf6DDPzZSoIBkoLFkC+ho97QrqnT6UU/ADM0tJP07ITaFPek4vofQjmclLUof78NqrPcJs5OIBl+gnKKJ4xCxcDmDnZZHvev5o1pk4gwtJIFIDxbq3piDr4Wq6cZpvGPPQTYC8YoVRTdVeeN+EcuklRrmaFzv8wCTSdI9wFJ9bsxtLedhq4gpkKqN5fbSguQg9JFsX3OJeT7KPfRd6SD1gu4Lpw5gwxthfOHcYsjM/eY5gaew8zzpN6mMUEJ1HqkNuQgOguHBxFnqFPiMz+Iadw7X38Yz+IgfUkOhN1iuvMhGYKbwKJ7rTiBVvGGpF6Wse1zFKgSiTLH2RnUAMkkHmxqk+JhbQKZpSWr6O8BfhHO1OKg7hpcHZtOJKNMjIF62WYDVf36w1h8h5fg==",
        //         "associated_data": "mch_payment",
        //         "nonce": "fdasflkja484w"
        //     }
        // }
        if (isset($data['resource'])) {
            $aes = new DecryptAes($this->config['mch_v3_key']);
            $data['resource'] = $aes->decryptToString(
                $data['resource']['associated_data'],
                $data['resource']['nonce'],
                $data['resource']['ciphertext']
            );
        }
        return $data;
    }
}
