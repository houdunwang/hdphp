<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\config;

use houdunwang\framework\build\Provider;

class ConfigProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
        //加载.env文件并加载配置文件
        Config::env('.env')->loadFiles(ROOT_PATH . '/system/config');

        //设置时区
        date_default_timezone_set(Config::get('app.timezone'));

        //调试时允许跨域访问
        if (Config::get('app.debug')) {
            header('Access-Control-Allow-Origin:*');
            header('Access-Control-Allow-Headers:*');
        }
    }

    public function register()
    {
        $this->app->single('Config', function () {
            return Config::single();
        });
    }
}