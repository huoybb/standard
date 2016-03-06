<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/6
 * Time: 9:09
 */
class standardHandler
{
    public function addWebFile($event, \Phalcon\Mvc\Model $model)
    {
        RedisFacade::delete('standard:archives:'.get_class($model));
        RedisFacade::delete('standard:archives:Files');
    }

    public function addFile($event)
    {
        RedisFacade::delete('standard:archives:Files');
    }

    public function deleteFile($event, Files $file)
    {
        $model = $file->getFileable();
        if($model) RedisFacade::delete('standard:archives:'.get_class($model));
        RedisFacade::delete('standard:archives:Files');
    }

    public function deleteSelectedFiles($event, $files)
    {
        RedisFacade::delete(RedisFacade::keys('standard:archives:*'));
    }

}