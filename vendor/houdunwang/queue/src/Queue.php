<?php namespace houdunwang\queue;

/**
 * 队列处理
 * Class Queue
 *
 * @package houdunwang\queue
 */
class Queue
{
    /**
     * 队列数据
     *
     * @var array
     */
    protected $data = [];
    /**
     * @var int
     */
    protected $num = 30;

    /**
     * 设置数据
     *
     * @param $data
     *
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * 队列数量
     *
     * @param $num
     *
     * @return $this
     */
    public function num($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * 设置数据
     *
     * @param $content
     */
    public function set($content)
    {
        while (count($this->data) >= $this->num) {
            array_shift($this->data);
        }
        $this->data[] = $content;
    }

    /**
     * 获取队列数据
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}