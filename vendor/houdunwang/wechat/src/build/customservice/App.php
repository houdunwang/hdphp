<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build\customservice;

use houdunwang\wechat\build\Base;

/**
 * 客服接口
 * Class App
 *
 * @package houdunwang\wechat\build
 */
class App extends Base
{
    use CustomManage, CustomMessage;
}