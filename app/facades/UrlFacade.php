<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/11
 * Time: 20:50
 */
class UrlFacade extends Facade
{
    public static function getFacadeAccessor(){
        return 'url';
    }
}