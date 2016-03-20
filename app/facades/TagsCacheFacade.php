<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/13
 * Time: 16:29
 */
class TagsCacheFacade extends myFacade
{
    public static function getFacadeAccessor()
    {
        return 'tagsCache';
    }
}