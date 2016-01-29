<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/30
 * Time: 7:13
 */
class SecurityFacade extends Facade
{
    public static function getFacadeAccessor(){
        return 'security';
    }
}