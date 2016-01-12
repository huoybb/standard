<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/12
 * Time: 6:15
 */
class cacheEventsHandler
{

    private $redis = null;
    /**
     * cacheEventsHandler constructor.
     */
    public function __construct()
    {
        $this->redis = \Phalcon\Di::getDefault()->get('redis');
    }

    public function deleteTagsCache()
    {
        $this->redis->deleteTags();
    }
}