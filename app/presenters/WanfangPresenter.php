<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:49
 */
class WanfangPresenter extends myPresenter
{
    public function title()
    {
        return '万方期刊：'.$this->entity->title;
    }
}