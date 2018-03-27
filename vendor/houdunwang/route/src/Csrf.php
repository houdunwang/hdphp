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

namespace houdunwang\route;

use houdunwang\arr\Arr;
use houdunwang\config\Config;
use houdunwang\cookie\Cookie;
use houdunwang\request\Request;
use houdunwang\response\Response;
use houdunwang\session\Session;

/**
 * 表单令牌验证
 * Trait Csrf
 *
 * @package houdunwang\view\build
 */
trait Csrf
{
    //验证令牌
    protected $token;

    /**
     * 检测令牌
     *
     * @throws \Exception
     */
    protected function csrfCheck()
    {
        $this->setServiceToken();
        $status = Config::get('csrf.open') && Request::post()
                  && ($_SERVER['HTTP_HOST'] == Request::getHost($_SERVER['HTTP_REFERER']));
        if ($status) {
            //比较CSRF
            if ($this->getClientToken() == $this->token) {
                return true;
            }
            //存在过滤的验证时忽略验证
            $except = Config::get('csrf.except');
            foreach ((array)$except as $f) {
                if (preg_match("@$f@i", __URL__)) {
                    return true;
                }
            }
            Response::sendHttpStatus(403);
            throw new \Exception('CSRF表单令牌验证失败');
        }
    }

    /**
     * 设置服务器令牌
     */
    protected function setServiceToken()
    {
        $token = Session::get('csrf_token');
        if (Config::get('csrf.open') && ! $token) {
            $token = md5(clientIp() . microtime(true));
            Session::set('csrf_token', $token);
            /**
             * 生成COOKIE令牌
             * 一些框架如AngularJs等框架会自动根据COOKIE中的token提交令牌
             */
            Cookie::set('XSRF-TOKEN', $token);
        }
        $this->token = $token;
    }

    /**
     * 获取端发送来的令牌
     *
     * @return mixed
     */
    protected function getClientToken()
    {
        $headers = Arr::keyCase(getallheaders(), 1);
        if (isset($headers['X-CSRF-TOKEN'])) {
            return $headers['X-CSRF-TOKEN'];
        }

        return Request::post('csrf_token');
    }
}