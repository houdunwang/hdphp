<?php namespace houdunwang\oss\build;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use houdunwang\config\Config;
use OSS\OssClient;

/**
 * Class Base
 *
 * @package houdunwang\oss\build
 */
class Base
{
    use sign;
    /**
     * oss实例
     *
     * @var \OSS\OssClient
     */
    protected $ossClient;
    /**
     * 储存块
     *
     * @var
     */
    protected $bucket;

    /**
     * 构造函数
     * Base constructor.
     */
    public function __construct()
    {
        $this->ossClient = new OssClient(
            Config::get('aliyun.accessId'), Config::get('aliyun.accessKey'),
            Config::get('oss.endpoint')
        );
        $this->bucket    = Config::get('oss.bucket');
    }

    /**
     * 调用组件方法控制OSS
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        array_unshift($arguments, $this->bucket);
        $fileInfo      = pathinfo($arguments['1']);
        $arguments[1]  = time().substr(md5($arguments[1]), 0, 5).mt_rand(0, 999).'.'.$fileInfo['extension'];
        $arr           = call_user_func_array([$this->ossClient, $name], $arguments);
        $arr['uptime'] = time();
        //文件上传时添加其他数据
        if (in_array($name, ['uploadFile'])) {
            $info             = pathinfo($arguments['2']);
            $arr['path']      = $arr['oss-request-url'];
            $arr['fieldname'] = '';
            $arr['basename']  = $info['basename'];
            $arr['filename']  = ''; //新文件名
            $arr['name']      = $info['filename']; //旧文件名
            $arr['size']      = $arr['info']['size_upload'];
            $arr['ext']       = $info['extension'];
            $arr['dir']       = '';
            $arr['image']     = in_array(strtolower($info['extension']), ['jpg', 'jpeg', 'png', 'gif']);
        }

        return $arr;
    }
}