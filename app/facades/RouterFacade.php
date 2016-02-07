<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/7
 * Time: 9:32
 */
class RouterFacade extends Facade
{
    public static function getFacadeAccessor(){
        return 'router';
    }
}