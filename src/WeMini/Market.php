<?php

namespace WeMini;

use WeChat\Contracts\BasicWeChat;

/**
 * 微信小程序服务市场
 * Class Ocr
 * @package WeMini
 */
class Market extends BasicWeChat
{
    /**
     * 调用服务平台上架的API
     * @param array $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function invoke($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/servicemarket?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 获取服务市场返回的数据
     * @param array $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function retrieve($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/servicemarketretrieve?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }


}