<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:50
 */
class WanfangthesisPresenter extends myPresenter
{
    public function title()
    {
        return '万方论文：'.$this->entity->title;
    }
}