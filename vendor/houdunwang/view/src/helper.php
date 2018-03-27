<?php
if ( ! function_exists('view')) {
    /**
     * 显示模板
     *
     * @param string $tpl
     * @param array  $vars
     *
     * @return mixed
     */
    function view($tpl = '', $vars = [])
    {
        return \houdunwang\view\View::make($tpl, $vars);
    }
}
if ( ! function_exists('widget')) {
    //解析页面组件
    function widget()
    {
        $vars = func_get_args();
        $info = preg_split('@[\./]@', array_shift($vars));
        //方法名
        $method = array_pop($info);
        //类名
        $className = array_pop($info);
        $class     = implode('\\', $info).'\\'.ucfirst($className);

        return call_user_func_array([new $class, $method], $vars);
    }
}

if ( ! function_exists('truncate')) {
    /**
     * 截取文字内容
     *
     * @param string $content 内容
     * @param int    $len     长度
     *
     * @return string
     */
    function truncate($content, $len = 30)
    {
        return mb_substr($content, 0, $len, 'utf8');
    }
}

if ( ! function_exists('view_path')) {
    /**
     * 模板目录
     *
     * @return string
     */
    function view_path()
    {
        return \houdunwang\view\View::getPath();
    }
}

if ( ! function_exists('csrf_field')) {
    /**
     * CSRF 表单
     *
     * @return string
     */
    function csrf_field()
    {
        return "<input type='hidden' name='csrf_token' value='".Session::get('csrf_token')."'/>\r\n";
    }
}

if ( ! function_exists('csrf_token')) {
    /**
     * CSRF 值
     *
     * @return mixed
     */
    function csrf_token()
    {
        return Session::get('csrf_token');
    }
}

if ( ! function_exists('view_url')) {
    /**
     * 模板目录链接
     *
     * @return string
     */
    function view_url()
    {
        return __ROOT__.'/'.view_path();
    }
}
if ( ! function_exists('widget_css')) {
    /**
     * 加载部件CSS文件
     *
     * @param $css
     *
     * @return string
     */
    function widget_css($css)
    {
        return "<style>".file_get_contents($css)."</style>";
    }
}

if ( ! function_exists('widget_js')) {
    /**
     * 加载部件JS文件
     *
     * @param $js
     *
     * @return string
     */
    function widget_js($js)
    {
        return "<script>".file_get_contents(__DIR__."/js/{$js}.js")."</script>";
    }
}

if ( ! function_exists('method_field')) {
    /**
     * CSRF 表单
     *
     * @param $type
     *
     * @return string
     */
    function method_field($type)
    {
        return "<input type='hidden' name='_method' value='".strtoupper($type)."'/>\r\n";
    }
}