<?php namespace houdunwang\cli\build;

/**
 * 命令行模式
 * Class Cli
 *
 * @package hdphp\cli
 * @author  向军 <2300071698@qq.com>
 */
class Base
{
    //绑定命令
    public $binds = [];
    protected static $errorMessage = '';
    //工作目录
    protected static $path
        = [
            'controller' => 'app/controller',
            'middleware' => 'app/middleware',
            'migration'  => 'app/migration',
            'model'      => 'app/model',
            'request'    => 'app/request',
            'seed'       => 'app/seed',
            'service'    => 'app/service',
            'tag'        => 'app/tag',
            'test'       => 'tests',
        ];

    /**
     * 以脚本方式执行命令
     *
     * @param string $cli 命令
     *
     * @return mixed
     */
    public function call($cli)
    {
        $_SERVER['argv'] = preg_split('/\s+/', $cli);

        //执行命令行指令
        return $this->bootstrap();
    }

    /**
     * 设置命令执行目录
     *
     * @param array $path
     */
    public static function setPath($path)
    {
        self::$path = $path;
    }

    /**
     * 执行命令运行
     *
     * @return mixed|void
     */
    public function bootstrap()
    {
        //去掉hd
        array_shift($_SERVER['argv']);
        $info = explode(':', array_shift($_SERVER['argv']));
        //执行用户绑定的命令处理类
        if (isset($this->binds[$info[0]])) {
            $class = $this->binds[$info[0]];
        } else {
            //系统命令类
            $class = 'houdunwang\cli\\build\\'.strtolower($info[0]).'\\'
                     .ucfirst($info[0]);
        }
        $action = isset($info[1]) ? $info[1] : 'run';
        //实例
        if (class_exists($class)) {
            return call_user_func_array([new $class(), $action], $_SERVER['argv']);
        } else {
            return $this->error('Command does not exist');
        }
    }

    /**
     * 绑定命令
     *
     * @param array $binds
     */
    public function setBinds($binds)
    {
        //加载扩展命令处理类
        $this->binds = array_merge($this->binds, $binds);
    }

    /**
     * 绑定命令
     *
     * @param string   $name     命令标识
     * @param \Closure $callback 闭包函数
     */
    public function bind($name, \Closure $callback)
    {
        $this->binds[$name] = $callback;
    }

    /**
     * 输出错误信息
     *
     * @param $content
     *
     * @return bool
     */
    final public function error($content)
    {
        if (RUN_MODE == 'CLI') {
            die(PHP_EOL."\033[;41m $content \x1B[0m\n".PHP_EOL);
        }
        $this->setError($content);

        return false;
    }

    /**
     * 成功信息
     *
     * @param $content
     *
     * @return bool
     */
    final public function success($content)
    {
        if (RUN_MODE == 'CLI') {
            die(PHP_EOL."\033[;36m $content \x1B[0m".PHP_EOL);
        }

        return true;
    }

    public function setError($content)
    {
        self::$errorMessage = $content;
    }

    /**
     * 获取执行错误
     *
     * @return string
     */
    public function getError()
    {
        return self::$errorMessage;
    }
}