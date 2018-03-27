<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\response\build;

use houdunwang\request\Request;
use houdunwang\route\Route;
use houdunwang\session\Session;
use houdunwang\view\View;
use houdunwang\xml\Xml;
use houdunwang\config\Config;

/**
 * Class Base
 *
 * @package houdunwang\response\build
 */
class Base
{
    //响应状态码
    protected $code;

    //响应内容
    protected $content;

    /**
     * 设置响应内容
     *
     * @param $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * 获取响应内容
     *
     * @return mixed
     */
    public function getContent()
    {
        if (is_array($this->content)) {
            return json_encode($this->content, JSON_UNESCAPED_UNICODE);
        }

        return is_numeric($this->content) ? strval($this->content) : $this->content;
    }

    /**
     * 直接响应内容
     *
     * @param $content
     *
     * @return $this
     */
    public function make($content)
    {
        $this->setContent($content);

        return $this;
    }

    /**
     * 跳转链接
     *
     * @param string $url
     * @param array  $args
     * @param bool   $merge
     *
     * @return $this
     */
    public function redirect($url = '', $args = [], $merge = false)
    {
        if ( ! empty($url)) {
            switch ($url) {
                case 'back':
                    $this->setContent(Request::history());
                    break;
                case 'refresh':
                    $this->setContent(Request::web());
                    break;
                default:
                    $this->controller($url, $args, $merge);
            }
        }

        return $this;
    }

    /**
     * 跳转到路由地址
     *
     * @param $route
     *
     * @return $this
     */
    public function route($route)
    {
        $this->setContent(web_url() . '/' . $route);

        return $this;
    }

    /**
     * 跳转控制器链接
     *
     * @param       $path
     * @param array $args
     * @param bool  $merge
     *
     * @return $this
     */
    public function controller($path, $args = [], $merge = false)
    {
        if (preg_match('@^http@i', $path)) {
            $url = $path;
        } else {
            $url        = Config::get('http.rewrite') ? root_url()
                : root_url() . '/' . basename($_SERVER['SCRIPT_FILENAME']);
            $path       = str_replace('.', '/', $path);
            $controller = Route::getController();
            if (empty($controller)) {
                //路由访问模式
                $url .= '?' . Config::get('http.url_var') . '=' . $path;
            } else {
                $info = explode('\\', $controller);
                //控制器访问模式
                switch (count(explode('/', $path))) {
                    case 2:
                        $path = $info[1] . '/' . $path;
                        break;
                    case 1:
                        $path = $info[1] . '/' . $info[3] . '/' . $path;
                        break;
                }

                $url .= '?' . Config::get('http.url_var') . '=' . $path;
            }
        }
        //添加参数
        if ( ! empty($args)) {
            if ($merge) {
                $args = array_merge($_GET ?: [], $args);
            }
            $url .= '&' . http_build_query($args);
        }
        $this->setContent($url);

        return $this;
    }

    /**
     * 分配闪存错误信息
     *
     * @param $content
     *
     * @return mixed
     */
    protected function withErrors($content)
    {
        $content = is_array($content) ? $content : [$content];

        return Session::flash($content);
    }

    /**
     * 返回字符内容
     *
     * @return mixed
     */
    public function string()
    {
        return $this->getContent();
    }

    public function __toString()
    {
        $content = $this->getContent();
        if (preg_match('/^http(s?):\/\//', $content)) {
            header('location:' . $content);
        }

        return $content ?: '';
    }

    /**
     * 输出404页面
     *
     * @return mixed
     */
    public function _404($return = false)
    {
//        $this->sendHttpStatus(404);
        if (RUN_MODE == 'HTTP') {
            if ($return) {
                return View::make(Config::get('app._404'));
            } else {
                die(View::make(Config::get('app._404')));
            }
        }
    }

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
    public function show($content, $redirect = 'back', $type = 'success', $timeout = 2)
    {
        $redirect = $redirect ?: 'back';
        if (Request::isMethod('ajax')) {
            return $this->setContent(['valid'   => $type == 'success' ? 1 : 0,
                                      'message' => $content,
            ]);
        } else {
            switch ($redirect) {
                case 'back':
                    $url = "location.replace('" . Request::history() . "')";
                    break;
                case 'refresh':
                    $url = "location.replace('" . request_url() . "')";
                    break;
                default:
                    $this->controller($redirect);
                    $url = "location.replace('" . $this->getContent() . "')";
                    break;
            }
            //图标
            $ico = [
                'success' => 'fa-check-circle',
                'error'   => 'fa-times-circle',
                'info'    => 'fa-info-circle',
                'warning' => 'fa-warning',
            ];
            View::with([
                'content'  => is_array($content) ? implode('<br/>', $content) : $content,
                'redirect' => $redirect,
                'type'     => $type,
                'url'      => $url,
                'ico'      => $ico[$type],
                'timeout'  => $timeout * 1000,
            ]);

            return View::make(Config::get('app.message'));
        }
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * 发送HTTP 状态码
     *
     * @param $code
     *
     * @return $this
     */
    public function sendHttpStatus($code)
    {
        $status = [
            // Informational 1xx
            100 => 'Continue',
            101 => 'Switching Protocols',
            // Success 2xx
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            // Redirection 3xx
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',  // 1.1
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            // 306 is deprecated but reserved
            307 => 'Temporary Redirect',
            // Client Error 4xx
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            // Server Error 5xx
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            509 => 'Bandwidth Limit Exceeded',
        ];
        if (isset($status[$code])) {
            $this->setCode($status[$code]);
            header('HTTP/1.1 ' . $code . ' ' . $status[$code]);
            header('Status:' . $code . ' ' . $status[$code]);

            return true;
        }

        return false;
    }

    /**
     * Ajax输出
     *
     * @param        $data 数据
     * @param string $type 数据类型 text xml json
     *
     * @return string
     */
    public function ajax($data, $type = "JSON")
    {
        switch (strtoupper($type)) {
            case "TEXT" :
                $res = $data;
                break;
            case "XML" :
                $res = (new Xml())->toSimpleXml($data);
                break;
            case 'JSON':
            default :
                $res = json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        return $res;
    }
}