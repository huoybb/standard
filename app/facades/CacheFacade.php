<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/15
 * Time: 8:38
 */
class CacheFacade extends Facade
{
    public static function getFacadeAccessor(){
        return 'cache';
    }
}