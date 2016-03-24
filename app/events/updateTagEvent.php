<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 16:35
 */
class updateTagEvent
{
    /**
     * @var Tags
     */
    public $tag;

    /**
     * updateTagEvent constructor.
     * @param Tags $tag
     */
    public function __construct(Tags $tag)
    {
        $this->tag = $tag;
    }
}