<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/27
 * Time: 21:00
 */
class SessionFacade extends myFacade
{
    public static function getFacadeAccessor()
    {
        return 'session';
    }
    public static function getAuthID(){
        return static::getService()->get('auth')['id'];
    }
    public static function hasAuth(){
        return static::has('auth');
    }

}