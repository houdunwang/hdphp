<?php namespace houdunwang\view\build;

/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use houdunwang\arr\Arr;
use houdunwang\config\Config;
use houdunwang\middleware\Middleware;
use houdunwang\request\Request;

class Base
{
    use Compile, Cache;

    //模板变量集合
    protected static $vars = [];

    //模版文件
    protected $file;

    //模板目录
    protected $path;

    /**
     * 返回视图实例
     *
     * @return \houdunwang\view\build\Base
     */
    public function instance()
    {
        return new self();
    }

    /**
     * 解析模板
     *
     * @param string $file 模板文件
     * @param mixed  $vars 分配的变量
     *
     * @return $this
     */
    public function make($file = '', $vars = [])
    {
        $this->setFile($file);
        $this->with($vars);
        Middleware::web('view_parse_file');

        return $this;
    }

    /**
     * 返回模板解析后的字符
     *
     * @param string $file
     * @param array  $vars
     *
     * @return string
     */
    public function fetch($file = '', $vars = [])
    {
        return $this->make($file, $vars)->parse();
    }

    /**
     * @param array $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * 获取模板文件
     *
     * @param $file 模板文件
     *
     * @return string|void
     */
    public function setFile($file)
    {
        //添加扩展名
        if ($file && ! preg_match('/\.[a-z]+$/i', $file)) {
            $file .= Config::get('view.prefix');
        }

        if (strstr($file, '/') && is_file($file)) {
            $this->file = $file;
        } else {
            $file = $this->path.'/'.$file;
            if (is_file($file)) {
                $this->file = $file;
            }
        }

    }

    /**
     * 获取模板文件
     *
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * 分配变量
     *
     * @param mixed  $vars  变量名
     * @param string $value 值
     *
     * @return $this
     */
    public function with($vars, $value = '')
    {
        self::setVars($vars, $value);

        return $this;
    }

    /**
     * 分配变量
     *
     * @param        $vars  变量名
     * @param string $value 值
     *
     * @return $this
     */
    public static function setVars($vars, $value = '')
    {
        $vars = is_array($vars) ? $vars : [$vars => $value];
        foreach ($vars as $k => $v) {
            self::$vars = Arr::set(self::$vars, $k, $v);
        }
    }

    /**
     * 获取所有分配变量
     *
     * @return array
     */
    public static function getVars()
    {
        return self::$vars;
    }

    /**
     * 解析处理
     *
     * @return string
     */
    protected function parse()
    {
        if ( ! is_file($this->file)) {
            trigger_error('模板文件不存在:'.$this->file, E_USER_ERROR);
        }
        $this->compile();
        ob_start();
        extract(self::getVars());
        include $this->compileFile;

        return ob_get_clean();
    }

    /**
     * 显示模板
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * 显示模板
     *
     * @return string
     */
    public function toString()
    {
        $open = Request::get('_cache', 1);
        if ($open && ($this->expire > 0) && ($cache = $this->getCache())) {
            return $cache;
        }
        $content = $this->parse();
        //创建缓存文件
        if ($open && $this->expire > 0) {
            $this->setCache($content);
        }

        return $content;
    }
}