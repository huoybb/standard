<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 17:20
 */
class deleteSelectedFilesEvent
{
    /**
     * @var \Phalcon\Mvc\Model\ResultsetInterface
     */
    public $files;

    /**
     * deleteSelectedFilesEvent constructor.
     * @param \Phalcon\Mvc\Model\ResultsetInterface $files
     */
    public function __construct($files)
    {
        $this->files = $files;
    }
}