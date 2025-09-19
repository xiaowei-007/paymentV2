<?php

namespace WePayPartner;

use WeChat\Exceptions\InvalidResponseException;
use WePayPartner\Contracts\BasicWePay;

/**
 * 服务商 | 转账到零钱接口
 * Class Transfers
 * @package WePayPartner
 */
class Transfers extends BasicWePay
{

    /**
     * 发起转账
     * @param array $data 转账参数
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4013080227
     */
    public function create(array $data)
    {
        $path = '/v3/partner-transfer/batches';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询转账批次单
     * @param string $outBatchNo 商户转账单号
     * @param boolean $needQueryDetail 是否查询转账明细单
     * @param integer $offset 请求资源起始位置
     * @param integer $limit 最大资源条数
     * @param string $detailStatus 明细状态
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4013080227
     */
    public function queryBatch($outBatchNo, $needQueryDetail = false, $offset = 0, $limit = 20, $detailStatus = '')
    {
        $pathinfo = "/v3/partner-transfer/batches/out-batch-no/{$outBatchNo}";
        $params = [
            'need_query_detail' => $needQueryDetail ? 'true' : 'false',
            'offset' => $offset,
            'limit' => $limit,
            'detail_status' => $detailStatus
        ];
        return $this->doRequest('GET', "{$pathinfo}?" . http_build_query($params), '', true);
    }

    /**
     * 查询转账明细单
     * @param string $outBatchNo 商户转账单号
     * @param string $outDetailNo 商户明细单号
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @document https://pay.weixin.qq.com/doc/v3/partner/4013080227
     */
    public function queryDetail($outBatchNo, $outDetailNo)
    {
        $pathinfo = "/v3/partner-transfer/batches/out-batch-no/{$outBatchNo}/details/out-detail-no/{$outDetailNo}";
        return $this->doRequest('GET', $pathinfo, '', true);
    }
}