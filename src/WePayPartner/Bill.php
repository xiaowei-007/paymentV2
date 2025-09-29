<?php

namespace WePayPartner;

use WeChat\Exceptions\InvalidResponseException;
use WePayPartner\Contracts\BasicWePay;

/**
 * 服务商 | 下载账单接口
 * Class Bill
 * @package WePayPartner
 */
class Bill extends BasicWePay
{

    /**
     * 申请交易账单
     * @param string $billDate 账单日期，格式yyyy-MM-DD
     * @param array $options 可选参数
     *   - sub_mchid: 子商户号（也叫特约商户号）
     *   - bill_type: 账单类型 ALL|SUCCESS|REFUND
     *   - tar_type: 压缩类型 GZIP
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4013080595
     */
    public function tradeBill($billDate, array $options = [])
    {
        $params = [
            'bill_date' => $billDate
        ];
        
        if (isset($options['sub_mchid'])) {
            $params['sub_mchid'] = $options['sub_mchid'];
        }
        
        if (isset($options['bill_type'])) {
            $params['bill_type'] = $options['bill_type'];
        }
        
        if (isset($options['tar_type'])) {
            $params['tar_type'] = $options['tar_type'];
        }
        
        $path = '/v3/bill/tradebill?' . http_build_query($params);
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 申请资金账单
     * @param string $billDate 账单日期，格式yyyy-MM-DD
     * @param array $options 可选参数
     *   - account_type: 资金账户类型 BASIC|OPERATION|FEES
     *   - tar_type: 压缩类型 GZIP
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4013080596
     */
    public function fundFlowBill($billDate, array $options = [])
    {
        $params = [
            'bill_date' => $billDate
        ];
        
        if (isset($options['account_type'])) {
            $params['account_type'] = $options['account_type'];
        }
        
        if (isset($options['tar_type'])) {
            $params['tar_type'] = $options['tar_type'];
        }
        
        $path = '/v3/bill/fundflowbill?' . http_build_query($params);
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 下载账单文件
     * @param string $downloadUrl 下载链接
     * @param string $filePath 保存文件路径
     * @param array $options 可选参数
     *   - tar_type: 压缩类型 GZIP
     * @return bool
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4013080597
     */
    public function download($downloadUrl, $filePath, array $options = [])
    {
        $path = parse_url($downloadUrl, PHP_URL_PATH);
        $query = parse_url($downloadUrl, PHP_URL_QUERY);
        if ($query) {
            $path .= '?' . $query;
        }
        
        // 使用doRequest方法获取文件内容
        $content = $this->doRequest('GET', $downloadUrl, '', false, false);
        
        // 处理压缩文件
        if (isset($options['tar_type']) && $options['tar_type'] === 'GZIP') {
            $content = gzdecode($content);
        }
        
        // 保存文件
        return file_put_contents($filePath, $content) !== false;
    }
}