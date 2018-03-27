<?php namespace houdunwang\framework;

/*--------------------------------------------------------------------------
| Software: [HDPHP framework]
| Site: www.hdphp.com
|--------------------------------------------------------------------------
| Author: 向军 <2300071698@qq.com>
| WeChat: houdunwangxj
| Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
|-------------------------------------------------------------------------*/
trait Version
{
    static public function version()
    {
        defined('HDPHP_VERSION') or define('HDPHP_VERSION', '3.0.138');
    }
}
