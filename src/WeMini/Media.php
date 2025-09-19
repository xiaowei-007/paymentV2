<?php

namespace WeMini;

use WeChat\Contracts\BasicWeChat;
use WeChat\Contracts\Tools;

/**
 * 小程序素材操作
 * Class Media
 * @package WeMini
 */
class Media extends BasicWeChat
{

    /**
     * 获取客服消息内的临时素材
     * @param array $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function get($media_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=' . $media_id;
        return $this->callGetApi($url);
    }

    /**
     * 新增图片素材
     * @param array $data
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function upload($filename)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=image';
        return $this->callPostApi($url, ['media' => Tools::createCurlFile($filename)], false);
    }
}