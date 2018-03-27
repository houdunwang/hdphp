<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\session;

use houdunwang\config\Config;

/**
 * SESSION处理
 * Class Session
 *
 * @package houdunwang\session
 */
class Session
{
    //操作驱动
    protected static $link;

    /**
     * 生成实例
     *
     * @return null|static
     */
    public static function single()
    {
        if (is_null(self::$link)) {
            $driver = ucfirst(Config::get('session.driver'));
            $class  = '\houdunwang\session\\build\\'.$driver.'Handler';
            self::$link = new $class();
        }
        return self::$link;
    }

    public function __call($method, $params)
    {
        return call_user_func_array([self::single(), $method], $params);
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::single(), $name], $arguments);
    }
}