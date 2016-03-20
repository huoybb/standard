<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/29
 * Time: 21:53
 */
class FlashFacade extends myFacade
{
    public static function getFacadeAccessor()
    {
        return 'flash';
    }

}