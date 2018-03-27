<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * |     Weibo: http://weibo.com/houdunwangxj
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\oss\build;

use houdunwang\config\Config;

/**
 * 为客户端上传生成签名
 * Trait sign
 *
 * @package houdunwang\oss\build
 */
trait sign
{
    //生成供前台使用的签名
    /**
     * @return string
     */
    public function sign($dir = '')
    {
        //阿里云 AccessKeyId
        $id = Config::get('aliyun.accessId');
        //阿里云  AccessKeySecret
        $key = Config::get('aliyun.accessKey');
        //OSS外网域名: 在阿里云后台OSS bucket中查看
        $host = Config::get('oss.host');
        //oss中本次上传存放文件的目录
        $dir        = $dir ? $dir : (isset($_GET['dir']) ? $_GET['dir'] : '');
        $now        = time();
        $expire     = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end        = $now + $expire;
        $expiration = $this->gmt_iso8601($end);

        //最大文件大小.用户可以自己设置
        $condition    = [0 => 'content-length-range', 1 => 0, 2 => 1048576000];
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start        = [0 => 'starts-with', 1 => '$key', 2 => $dir];
        $conditions[] = $start;

        $arr            = ['expiration' => $expiration, 'conditions' => $conditions];
        $policy         = json_encode($arr);
        $base64_policy  = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature      = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response              = [];
        $response['accessid']  = $id;
        $response['host']      = $host;
        $response['policy']    = $base64_policy;
        $response['signature'] = $signature;
        $response['expire']    = $end;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;

        return json_encode($response);
    }

    /**
     * @param $time
     *
     * @return string
     */
    public function gmt_iso8601($time)
    {
        $dtStr      = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos        = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);

        return $expiration."Z";
    }
}