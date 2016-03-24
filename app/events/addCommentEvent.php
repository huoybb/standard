<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 7:34
 */
class addCommentEvent
{
    /**
     * @var myModel
     */
    public $object;
    /**
     * @var Comments
     */
    public $comment;

    /**
     * addCommentEvent constructor.
     * @param myModel $object
     * @param Comments $comment
     */
    public function __construct($object, $comment)
    {
        $this->object = $object;
        $this->comment = $comment;
    }
}