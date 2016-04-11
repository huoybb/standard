<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:46
 */
class CiteseerxPresenter extends myPresenter
{
    public function title()
    {
        return 'CiteSeerx：'.$this->entity->title;
    }

}