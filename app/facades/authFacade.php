<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/26
 * Time: 23:35
 */
class AuthFacade extends myFacade
{
    public static function getFacadeAccessor()
    {
        return 'auth';
    }
    public static function getID(){
        return static::getService()->id;
    }
}