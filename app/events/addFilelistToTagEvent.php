<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 16:47
 */
class addFilelistToTagEvent
{
    /**
     * @var array
     */
    public $file_ids;
    /**
     * @var Tags
     */
    public $tag;

    /**
     * FilelistWasAddedToTag constructor.
     * @param array $file_ids
     * @param Tags $tag
     */
    public function __construct($file_ids, Tags $tag)
    {
        $this->file_ids = $file_ids;
        $this->tag = $tag;
    }
}