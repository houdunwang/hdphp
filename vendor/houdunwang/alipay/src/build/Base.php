<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\alipay\build;

use houdunwang\alipay\service\PagePayService;
use houdunwang\config\Config;
use houdunwang\request\Request;

/**
 * 支付宝
 * Class Base
 *
 * @package houdunwang\alipay\build
 */
class Base
{
    use PagePayService;

    /**
     * 签名验证
     * 支付宝通知时的签名验证
     * 验证通过后才可以更新定单信息
     * @return bool
     */
    public function signCheck()
    {
        $alipaySevice = new \AlipayTradeService(Config::get('alipay'));

        return $alipaySevice->check(Request::request());
    }
}