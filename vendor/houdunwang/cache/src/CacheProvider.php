<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\cache;

use houdunwang\framework\build\Provider;

/**
 * 缓存服务提供者
 * Class CacheServiceProvider
 *
 * @package Hdphp\Cache
 * @author  向军 <2300071698@qq.com>
 */
class CacheProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
    }

    public function register()
    {
        $this->app->single('Cache', function () {
            return new Cache();
        });
    }
}