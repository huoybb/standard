<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/27
 * Time: 21:00
 */
class SessionFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'session';
    }
    public static function getID(){
        return static::getService()->get('auth')['id'];
    }

}