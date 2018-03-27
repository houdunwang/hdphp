<?php
if ( ! function_exists('request_url')) {
    /**
     * 请求的URL地址
     *
     * @return string
     */
    function request_url()
    {
        return \houdunwang\request\Request::url();
    }
}

if ( ! function_exists('history_url')) {
    /**
     * 来源链接
     *
     * @return string
     */
    function history_url()
    {
        return \houdunwang\request\Request::history();
    }
}
if ( ! function_exists('root_url')) {
    /**
     * 网站根地址URI
     *
     * @return string
     */
    function root_url()
    {
        return \houdunwang\request\Request::domain();
    }
}

if ( ! function_exists('domain_url')) {
    /**
     * 网站根地址URI
     *
     * @return string
     */
    function domain_url()
    {
        return \houdunwang\request\Request::domain();
    }
}

if ( ! function_exists('web_url')) {
    /**
     * 网站主页
     * 根据配置项 http.rewrite判断
     * 没有开启伪静态时添加index.php入口文件
     *
     * @param bool $hasRoot 包含入口文件
     *
     * @return string
     */
    function web_url($hasRoot = false)
    {
        if ($hasRoot) {
            return __ROOT__.'/index.php';
        }

        return \houdunwang\request\Request::web();
    }
}

if ( ! function_exists('q')) {
    /**
     * 取得或设置全局数据包括:
     * $_COOKIE,$_SESSION,$_GET,$_POST,$_REQUEST,$_SERVER,$_GLOBALS
     *
     * @param string $var     变量名
     * @param mixed  $default 默认值
     * @param string $methods 函数库
     *
     * @return mixed
     */
    function q($var, $default = null, $methods = '')
    {
        return \houdunwang\request\Request::query($var, $default, $methods);
    }
}

if ( ! function_exists('old')) {
    /**
     * 获取表单旧数据
     *
     * @param        $name    表单
     * @param string $default 默认值
     *
     * @return string
     */
    function old($name, $default = '')
    {
        $data = \houdunwang\session\Session::flash('oldFormData');

        return isset($data[$name]) ? $data[$name] : $default;
    }
}
if ( ! function_exists('clientIp')) {
    /**
     * 客户端IP地址
     *
     * @return mixed
     */
    function clientIp()
    {
        return \houdunwang\request\Request::ip();
    }
}

if ( ! function_exists('getallheaders')) {
    /**
     * 获取请求头信息
     *
     * @return mixed
     */
    function getallheaders()
    {
        return \houdunwang\request\Request::getallheaders();
    }
}