<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/26
 * Time: 23:24
 */
class redisFacade extends facade
{
    public static function getFacadeAccessor()
    {
        return 'redis';
    }

}