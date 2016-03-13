<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/31
 * Time: 17:51
 */
class myRedis
{
    protected $redis = null;

    /**
     * myRedis constructor.
     */
    public function __construct()
    {
        $this->redis = new Redis();
        if(!$this->redis->connect('127.0.0.1', 6379)){
            dd('Redis服务连接不成功，请检查！');
        };
    }

    /**
     * @param $key
     * @return bool
     */
    public function exist($key)
    {
        return $this->redis->exists($key);
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value)
    {
        return $this->redis->set($key,$value);
    }

    /**
     * @param $key
     * @return bool|string
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * @param $key
     * @return int Number of keys deleted.
     */
    public function delete($key)
    {
        return $this->redis->del($key);
    }

    /**
     * @param $pattern
     * @return array
     */
    public function keys($pattern)
    {
        return $this->redis->keys($pattern);
    }
    

    /**
     * @param $key
     * @param int $value
     * @return int
     */
    public function increment($key, $value = 1) {
        return $this->redis->incrBy($key,$value);
    }

    /**
     * @param $key
     * @param int $value
     * @return int
     */
    public function decrement($key, $value = 1) {
        return $this->redis->decrBy($key,$value);
    }

    public function getPrefix() {
        return 'standard:';
    }


}