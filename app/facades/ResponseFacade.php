<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/11
 * Time: 20:39
 */
class ResponseFacade extends Facade
{
    public static function getFacadeAccessor(){
        return 'response';
    }
}