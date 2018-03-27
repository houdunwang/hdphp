<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\framework\middleware;

use houdunwang\middleware\build\Middleware;
use houdunwang\route\Route;
use houdunwang\view\View;

/**
 * 模板文件
 * 如果是控制器请求且视图文件不存在时设置方法名为文件名
 * Class ViewParseFile
 *
 * @package houdunwang\framework\middleware
 */
class ViewParseFile implements Middleware
{
    public function run($next)
    {
        if (empty(View::getFile())) {
            if ($action = Route::getAction()) {
                View::setFile($action);
            }
        }
        $next();
    }
}