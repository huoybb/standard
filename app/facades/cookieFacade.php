<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/27
 * Time: 7:16
 */
class CookieFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'cookies';
    }

}