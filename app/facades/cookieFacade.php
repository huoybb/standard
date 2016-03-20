<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/27
 * Time: 7:16
 */
class CookieFacade extends myFacade
{
    public static function getFacadeAccessor()
    {
        return 'cookies';
    }

    public static function remove($key){
        return static::getService()->get($key)->delete();
    }
    public static function get($key){
        return json_decode(CryptFacade::decrypt(static::getService()->get($key)->getValue()));
    }
    public static function set($key, $object, $duration){
        return static::getService()->set($key,CryptFacade::encrypt(json_encode($object)),$duration);
    }

}