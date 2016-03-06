<?php
$eventManager = new myEventManager();

//$em->attach('auth',new authEventsHandler());
$eventManager->register('auth',[authEventsHandler::class]);

$eventManager->listen('tags:updateTag',cacheEventsHandler::class.'::deleteTagsCache');
$eventManager->listen('tags:updateTag',tagsEventsHandler::class.'::updateMeta');

$eventManager->listen('tags:addComment',activityHandler::class.'::addComment');
$eventManager->listen('files:addComment',activityHandler::class.'::addComment');

$eventManager->attach('taggables',new taggablesEventsHandler());

$eventManager->attach('standards:addWebFile',function($event, \Phalcon\Mvc\Model $model){
    RedisFacade::delete('standard:archives:'.get_class($model));
    RedisFacade::delete('standard:archives:Files');
});
$eventManager->attach('standards:addFile',function($event, $model){
    RedisFacade::delete('standard:archives:Files');
});

$eventManager->attach('standards:deleteFile',function($event, Files $file){
    $model = $file->getFileable();
    if($model) RedisFacade::delete('standard:archives:'.get_class($model));
    RedisFacade::delete('standard:archives:Files');
});
$eventManager->attach('standards:deleteSelectedFiles',function($event, $files){
    RedisFacade::delete(RedisFacade::keys('standard:archives:*'));
});
$eventManager->register('search',[searchEventHandler::class]);
return $eventManager;