<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 17:13
 */
class addFileEvent
{
    /**
     * @var static
     */
    public $file;

    /**
     * addFileEvent constructor.
     * @param myModel $file
     */
    public function __construct(myModel $file)
    {
        $this->file = $file;
    }
}