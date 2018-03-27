<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\view;

use houdunwang\config\Config;
use houdunwang\framework\build\Provider;
use houdunwang\view\build\Csrf;

class ViewProvider extends Provider
{
    //延迟加载
    public $defer = false;

    public function boot()
    {
        View::setPath(Config::get('view.path'));
    }

    public function register()
    {
        $this->app->single('View', function () {
            return View::single();
        });
    }
}