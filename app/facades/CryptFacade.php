<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/30
 * Time: 7:20
 */
class CryptFacade extends myFacade
{
    public static function getFacadeAccessor(){
        return 'crypt';
    }
}