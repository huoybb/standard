<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/28
 * Time: 0:48
 */
class getWebDataEvent
{
    public $type;
    public $source_id;

    /**
     * getWebDataEvent constructor.
     * @param $type
     * @param $source_id
     */
    public function __construct($type, $source_id)
    {
        $this->type = $type;
        $this->source_id = $source_id;
    }
}