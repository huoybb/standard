<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/26
 * Time: 23:35
 */
class AuthFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'auth';
    }

}