<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/26
 * Time: 23:13
 */
abstract class facade
{

    public static function getInstance()
    {
        return null;
    }
    public static function getService()
    {
        return \Phalcon\Di::getDefault()->get(static::getInstance());
    }
    public static function __callStatic($method, $args)
    {
        $instance = static::getService();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        switch (count($args)) {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($args[0]);

            case 2:
                return $instance->$method($args[0], $args[1]);

            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);

            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);

            default:
                return call_user_func_array([$instance, $method], $args);
        }
    }
}