<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/12
 * Time: 6:15
 */
class cacheEventsHandler
{

    public function whenupdateTagEvent(updateTagEvent $event)
    {
        $key = 'standard:users:'.AuthFacade::getID().':tags';
        RedisFacade::delete($key);
    }
    public function whenaddWebFileEvent(addWebFileEvent $event)
    {
        RedisFacade::delete('standard:archives:'.get_class($event->model));
        RedisFacade::delete('standard:archives:Files');
    }
    public function whenaddFileEvent(addFileEvent $event)
    {
        RedisFacade::delete('standard:archives:Files');
    }
    
    public function whendeleteFileEvent(deleteFileEvent $event)
    {
        $file = $event->file;
        $model = $file->getFileable();
        if($model) RedisFacade::delete('standard:archives:'.get_class($model));
        RedisFacade::delete('standard:archives:Files');
    }
    public function whendeleteSelectedFilesEvent(deleteSelectedFilesEvent $event)
    {
        RedisFacade::delete(RedisFacade::keys('standard:archives:*'));
    }
    public function whensearchEvent(searchEvent $event){
        RedisFacade::delete(RedisFacade::keys('standard:search:*'));
    }
    public function whengetWebDataEvent(getWebDataEvent $event)
    {
        RedisFacade::delete('standard:subrepository:statistics');
    }
    public function whenfileableDeleteEvent(fileableDeleteEvent $event)
    {
        RedisFacade::delete('standard:subrepository:statistics');
    }


}