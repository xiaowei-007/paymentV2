<?php

namespace WePayV3;

use WeChat\Exceptions\InvalidResponseException;
use WePayV3\Contracts\BasicWePay;
use WePayV3\Contracts\DecryptAes;

/**
 * 平台证书管理
 * Class Cert
 * @package WePayV3
 */
class Cert extends BasicWePay
{

    /**
     * 自动配置平台证书
     * @var bool
     */
    protected $autoCert = false;

    /**
     * 商户平台下载证书
     * @return void
     * @throws \WeChat\Exceptions\InvalidResponseException
     */
    public function download()
    {
        try {
            $certs = [];
            $result = $this->doRequest('GET', '/v3/certificates');
            
            // 检查返回结果是否包含data键
            if (!isset($result['data']) || !is_array($result['data'])) {
                throw new InvalidResponseException('证书下载接口返回数据格式错误，缺少data字段');
            }
            
            $decrypt = new DecryptAes($this->config['mch_v3_key']);
            foreach ($result['data'] as $vo) {
                // 检查必要字段是否存在
                if (!isset($vo['serial_no']) || !isset($vo['expire_time']) || !isset($vo['encrypt_certificate'])) {
                    continue; // 跳过不完整的证书数据
                }
                
                $certs[$vo['serial_no']] = [
                    'expire'  => strtotime($vo['expire_time']),
                    'serial'  => $vo['serial_no'],
                    'content' => $decrypt->decryptToString(
                        $vo['encrypt_certificate']['associated_data'],
                        $vo['encrypt_certificate']['nonce'],
                        $vo['encrypt_certificate']['ciphertext']
                    )
                ];
            }
            $this->tmpFile("{$this->config['mch_id']}_certs", $certs);
        } catch (\Exception $exception) {
            throw new InvalidResponseException($exception->getMessage(), $exception->getCode());
        }
    }
}