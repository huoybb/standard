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

    /**获取并清除session中的数据，简化原来的get长命令
     * @param $name
     * @return mixed
     */
    public static function pluck($name)
    {
        return static::get($name,null,true);
    }

}