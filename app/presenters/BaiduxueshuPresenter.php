<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:16
 */
class BaiduxueshuPresenter extends myPresenter
{
    public function title()
    {
        return '百度学术：'.$this->entity->title;
    }

}