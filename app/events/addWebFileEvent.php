<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 17:09
 */
class addWebFileEvent
{
    /**
     * @var FileableInterface|\Phalcon\Mvc\Model
     */
    public $model;

    /**
     * addWebFileEvent constructor.
     * @param FileableInterface|\Phalcon\Mvc\Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
}