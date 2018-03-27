<?php namespace houdunwang\route;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use houdunwang\framework\build\Provider;
use houdunwang\config\Config;

class RouteProvider extends Provider
{
    use Csrf;

    //延迟加载
    public $defer = false;

    public function boot()
    {
        Config::set('controller.app', Config::get('app.path'));
        Config::set('route.cache', Config::get('http.route_cache'));
        //CSRF验证
        $this->csrfCheck();
    }

    public function register()
    {
        $this->app->single('Route', function () {
            return Route::single();
        });
    }
}