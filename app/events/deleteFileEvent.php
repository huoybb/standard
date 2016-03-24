<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 17:17
 */
class deleteFileEvent
{
    /**
     * @var Files
     */
    public $file;

    /**
     * deleteFileEvent constructor.
     * @param Files $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }
}