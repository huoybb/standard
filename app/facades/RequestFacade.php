<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/11
 * Time: 7:55
 */
class RequestFacade extends myFacade
{
    public static function getFacadeAccessor(){
        return 'request';
    }
}