<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:49
 */
class WanfangconferencePresenter extends myPresenter
{
    public function title()
    {
        return '万方会议：'.$this->entity->title;
    }
}