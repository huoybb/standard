<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/27
 * Time: 7:31
 */
class EventFacade extends myFacade
{
    public static function getFacadeAccessor()
    {
        return 'eventsManager';
    }
}