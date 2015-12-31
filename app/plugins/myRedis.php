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
        $this->redis->connect('127.0.0.1', 6379);
    }
    public function exist($key)
    {
        return $this->redis->exists($key);
    }

    public function set($key,$value)
    {
        return $this->redis->set($key,$value);
    }
    public function get($key)
    {
        return $this->redis->get($key);
    }

    //针对tags的缓冲函数
    protected function getTagsKey(Users $user = null)
    {
        if($user == null) $user = \Phalcon\Di::getDefault()->get('auth');
        return 'standard:user-'.$user->id.':tags';
    }
    public function isTagsExist(Users $user = null)
    {
        return $this->exist($this->getTagsKey($user));
    }
    public function setTags($tags,$user = null)
    {
        return $this->set($this->getTagsKey($user),json_encode($tags));
    }
    public function getTags($user = null)
    {
        return json_decode($this->get($this->getTagsKey($user)));
    }
    public function deleteTags($user = null)
    {
        $this->redis->delete($this->getTagsKey($user));
    }






}