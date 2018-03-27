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

namespace houdunwang\framework\build;

use houdunwang\config\Config;
use houdunwang\framework\middleware\ViewParseFile;
use houdunwang\middleware\Middleware;
use houdunwang\request\Request;
use houdunwang\response\Response;
use houdunwang\route\Route;
use houdunwang\session\Session;
use houdunwang\view\View;

trait Bootstrap
{
    protected function runApp()
    {
        if (RUN_MODE == 'HTTP') {
            //解析路由
            require ROOT_PATH.'/system/routes.php';
            //执行全局中间件
            $this->middleware(Config::get('middleware.global'));
            //分配闪存错误信息
            $this->withErrors();
            //模板文件处理中间件
            Middleware::add('view_parse_file', [ViewParseFile::class]);
            //执行路由或控制器方法
            $content = Route::bootstrap()->exec();
            echo is_object($content) ? $content : Response::make($content);
        }
    }

    /**
     * 分配闪存错误信息
     */
    protected function withErrors()
    {
        //分配SESSION闪存中的错误信息
        View::with('errors', Session::flash('errors'));
        if ($post = Request::post()) {
            Session::flash('oldFormData', $post);
        }
    }
}