<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/26
 * Time: 23:24
 */
class RedisFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'redis';
    }

}