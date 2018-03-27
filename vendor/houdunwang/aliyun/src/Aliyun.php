<?php namespace houdunwang\aliyun;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use houdunwang\config\Config;

include_once __DIR__.'/../aliyun-openapi-php-sdk-master/aliyun-php-sdk-core/Config.php';

class Aliyun
{
    /**
     * 获取阿里云执行请求客户端
     *
     * @return \DefaultAcsClient
     */
    public static function client()
    {
        //regionId,根据服务器所在区域进行选择 https://help.aliyun.com/document_detail/40654.html?spm=5176.7114037.1996646101.1.OCtdEo
        $regionId        = Config::get('aliyun.regionId');
        $accessKeyId     = Config::get('aliyun.accessId');
        $accessKeySecret = Config::get('aliyun.accessKey');
        $iClientProfile  = \DefaultProfile::getProfile($regionId, $accessKeyId, $accessKeySecret);
        return new \DefaultAcsClient($iClientProfile);
    }

    /**
     * 获取鉴权地址
     * 如获取直播推流与播放流地址
     *
     * @param string $url  地址
     * @param string $key  密钥
     * @param int    $hour 鉴权有效时间，超过这个时间不允许OBS等软件进行推流
     *
     * @return string
     */
    public static function url($url, $key, $hour)
    {
        $param    = parse_url($url);
        $time     = strtotime("+{$hour} hours");
        $key      = $key;
        $domain   = "{$param['scheme']}://{$param['host']}";
        $filename = $param['path'];
        $sstring  = $filename."-".$time."-0-0-".$key;
        $md5      = md5($sstring);
        $auth_key = "auth_key=".$time."-0-0-".$md5;

        return $domain.$filename."?".$param['query']."&".$auth_key;
    }
}