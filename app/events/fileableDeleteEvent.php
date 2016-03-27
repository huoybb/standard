<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/28
 * Time: 0:53
 */
class fileableDeleteEvent
{
    /**
     * @var FileableInterface
     */
    public $sub;

    /**
     * fileableDeleteEvent constructor.
     * @param FileableInterface $sub
     */
    public function __construct(FileableInterface $sub)
    {

        $this->sub = $sub;
    }
}