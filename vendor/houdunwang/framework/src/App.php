<?php namespace houdunwang\framework;

/*--------------------------------------------------------------------------
| Software: [HDPHP framework]
| Site: www.hdphp.com
|--------------------------------------------------------------------------
| Author: 向军 <2300071698@qq.com>
| WeChat: houdunwangxj
| Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
|-------------------------------------------------------------------------*/

use houdunwang\framework\build\Base;

class App
{
    protected static $link;

    public function __call($method, $params)
    {
        return call_user_func_array([self::single(), $method], $params);
    }

    //生成单例对象
    public static function single()
    {
        if (!self::$link) {
            self::$link = new Base();
        }

        return self::$link;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::single(), $name], $arguments);
    }
}
