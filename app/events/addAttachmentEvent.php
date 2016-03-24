<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 11:07
 */
class addAttachmentEvent
{
    /**
     * @var Tags
     */
    public $object;
    /**
     * @var array
     */
    public $files;

    /**
     * addAttachmentEvent constructor.
     * @param myModel $object
     * @param array $files
     */
    public function __construct($object, $files)
    {
        $this->object = $object;
        $this->files = $files;
    }
}