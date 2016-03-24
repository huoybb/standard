<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/12
 * Time: 6:15
 */
class cacheEventsHandler
{

    public function updateTagEvent($e, updateTagEvent $event)
    {
        TagsCacheFacade::deleteTags();
    }
    public function addWebFileEvent($e, addWebFileEvent $event)
    {
        RedisFacade::delete('standard:archives:'.get_class($event->model));
        RedisFacade::delete('standard:archives:Files');
    }
    public function addFileEvent($e,addFileEvent $event)
    {
        RedisFacade::delete('standard:archives:Files');
    }
    
    public function deleteFileEvent($e,deleteFileEvent $event)
    {
        $file = $event->file;
        $model = $file->getFileable();
        if($model) RedisFacade::delete('standard:archives:'.get_class($model));
        RedisFacade::delete('standard:archives:Files');
    }
    public function deleteSelectedFilesEvent($e,deleteSelectedFilesEvent $event)
    {
        RedisFacade::delete(RedisFacade::keys('standard:archives:*'));
    }

    

}