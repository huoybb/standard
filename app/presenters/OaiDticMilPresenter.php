<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:48
 */
class OaiDticMilPresenter extends myPresenter
{
    public function title()
    {
        return 'DTIC：'.$this->entity->title;
    }
}