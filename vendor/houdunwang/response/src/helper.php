<?php
if ( ! function_exists('ajax')) {
    /**
     * Ajax输出
     *
     * @param  mixed $data 数据
     * @param string $type 数据类型 text html xml json
     */
    function ajax($data, $type = "JSON")
    {
        return \houdunwang\response\Response::ajax($data, $type);
    }
}


if ( ! function_exists('confirm')) {
    /**
     * 有确定提示的提示页面
     *
     * @param string $message 提示文字
     * @param string $sUrl    确定按钮跳转的url
     * @param string $eUrl    取消按钮跳转的url
     *
     * @return mixed
     */
    function confirm($message, $sUrl, $eUrl)
    {
        View::with(['message' => $message, 'sUrl' => $sUrl, 'eUrl' => $eUrl]);

        return view(Config::get('app.confirm'));
    }
}

if ( ! function_exists('message')) {
    /**
     * 消息提示
     *
     * @param        $content  消息内容
     * @param string $redirect 跳转地址有三种方式 1:back(返回上一页)  2:refresh(刷新当前页)  3:具体Url
     * @param string $type     信息类型  success(成功），error(失败），warning(警告），info(提示）
     * @param int    $timeout  等待时间
     *
     * @return mixed|string
     */
    function message($content, $redirect = 'back', $type = 'success', $timeout = 2)
    {
        return \houdunwang\response\Response::show($content, $redirect, $type, $timeout);
    }
}

if ( ! function_exists('u')) {
    /**
     * 生成控制器链接
     *
     * @param string $path 模块.动作.方法
     * @param array  $args GET参数
     * @param bool   $merge
     *
     * @return mixed
     */
    function u($path, $args = [], $merge = false)
    {
        return redirect($path, $args, $merge)->string();
    }
}
if ( ! function_exists('go')) {
    /**
     * 跳转网址
     *
     * @param $path
     * @param $args
     *
     * @return mixed
     */
    function go($path, $args = [])
    {
        return redirect($path, $args);
    }
}

if ( ! function_exists('redirect')) {
    /**
     * 跳转链接
     *
     * @param string $url  back/refresh/控制器
     * @param array  $args 链接参数
     * @param bool   $merge
     *
     * @return mixed
     */
    function redirect($url = '', array $args = [], $merge = false)
    {
        return \houdunwang\response\Response::redirect($url, $args, $merge);
    }
}

if ( ! function_exists('url_del')) {
    /**
     * 从__URL__地址中删除指令的$_GET参数
     *
     * @param string|array $args
     *
     * @return string
     */
    function url_del($args)
    {
        if ( ! is_array($args)) {
            $args = [$args];
        }
        $url = parse_url(__URL__);
        parse_str($url['query'], $output);
        foreach ($args as $v) {
            if (isset($output[$v])) {
                unset($output[$v]);
            }
        }
        $url = $url['scheme'].'://'.$url['host'].$url['path'].'?';
        foreach ($output as $k => $v) {
            $url .= $k.'='.$v.'&';
        }

        return trim($url, '&');
    }
}