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

namespace houdunwang\middleware\build;

use houdunwang\response\Response;

trait Dispatcher
{
    /**
     * 执行中间件
     *
     * @param $middleware
     */
    public function middleware($middleware)
    {
        $middleware = array_reverse($middleware);
        $dispatcher = array_reduce($middleware, $this->getSlice(), function () {
        });
        $dispatcher();
    }

    /**
     * @return \Closure
     */
    protected function getSlice()
    {
        return function ($next, $step) {
            return function () use ($next, $step) {
                if ($content = call_user_func_array([new $step, 'run'], [$next])) {
                    die(is_string($content) ? Response::make($content) : $content);
                }
            };
        };
    }
}