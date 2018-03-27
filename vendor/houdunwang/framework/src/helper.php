<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
if ( ! function_exists('app')) {
    /**
     * 获取应用实例
     *
     * @param string $name 外观名称
     *
     * @return mixed
     */
    function app($name = 'App')
    {
        return \App::make($name);
    }
}

if ( ! function_exists('pic')) {
    /**
     * 显示图片
     * 判断提供的图片文件是否合法
     * 不是合法图片时返回默认图片替换
     *
     * @param        $file
     * @param string $pic
     *
     * @return string
     */
    function pic($file, $pic = 'resource/images/thumb.jpg')
    {
        if (preg_match('@^http@i', $file)) {
            return $file;
        } elseif (empty($file) || ! is_file($file)) {
            return __ROOT__.'/'.$pic;
        } else {
            return __ROOT__.'/'.$file;
        }
    }
}

if ( ! function_exists('p')) {
    /**
     * 打印输出数据
     *
     * @param $var
     */
    function p($var)
    {
        echo "<pre>".print_r($var, true)."</pre>";
    }
}

if ( ! function_exists('dd')) {
    /**
     * 打印数据有数据类型
     *
     * @param $var
     */
    function dd($var)
    {
        ob_start();
        var_dump($var);
        die("<pre>".ob_get_clean()."</pre>");
    }
}

if ( ! function_exists('print_const')) {
    /**
     * 打印用户常量
     */
    function print_const()
    {
        $d = get_defined_constants(true);
        p($d['user']);
    }
}

if ( ! function_exists('v')) {
    /**
     * 全局变量
     *
     * @param null   $name  变量名
     * @param string $value 变量值
     *
     * @return array|mixed|null|string
     */
    function v($name = null, $value = '[null]')
    {
        static $vars = [];
        if (is_null($name)) {
            return $vars;
        } else if ($value == '[null]') {
            //取变量
            $tmp = $vars;
            foreach (explode('.', $name) as $d) {
                if (isset($tmp[$d])) {
                    $tmp = $tmp[$d];
                } else {
                    return null;
                }
            }

            return $tmp;
        } else {
            //设置
            $tmp = &$vars;
            foreach (explode('.', $name) as $d) {
                if ( ! isset($tmp[$d])) {
                    $tmp[$d] = [];
                }
                $tmp = &$tmp[$d];
            }

            return $tmp = $value;
        }
    }
}

/**
 * 获取几分/几秒前的表示
 *
 * @param string $time 时间ISO格式如 2020-2-22 10:22:32
 *
 * @return int
 */
if ( ! function_exists('time_diff')) {
    function time_diff($time)
    {
        $dt  = new \Carbon\Carbon($time);
        $now = \Carbon\Carbon::now();
        $num = $dt->diffInSeconds($now);
        if ($num < 20) {
            return '刚刚';
        } elseif ($num < 60) {
            $unit = '秒前';
        } elseif ($num < 3600) {
            $unit = '分钟前';
            $num  = $num / 60;
        } else if ($num < (24 * 3600)) {
            $unit = '小时前';
            $num  = $num / 3600;
        } else {
            $unit = '天前';
            $num  = $num / (24 * 3600);
        }

        return intval($num).$unit;
    }
}