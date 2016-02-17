<?php
$em = new myEventManager();

//$em->attach('auth',new authEventsHandler());
$em->register('auth',[authEventsHandler::class]);

$em->listen('tags:updateTag',cacheEventsHandler::class.'::deleteTagsCache');
$em->listen('tags:updateTag',tagsEventsHandler::class.'::updateMeta');

$em->attach('taggables',new taggablesEventsHandler());

$em->attach('standards:addWebFile',function($event,\Phalcon\Mvc\Model $model){
    RedisFacade::delete('standard:archives:'.get_class($model));
    RedisFacade::delete('standard:archives:Files');
});
$em->attach('standards:addFile',function($event,$model){
    RedisFacade::delete('standard:archives:Files');
});

$em->attach('standards:deleteFile',function($event,Files $file){
    $model = $file->getFileable();
    if($model) RedisFacade::delete('standard:archives:'.get_class($model));
    RedisFacade::delete('standard:archives:Files');
});
$em->attach('standards:deleteSelectedFiles',function($event,$files){
    RedisFacade::delete(RedisFacade::keys('standard:archives:*'));
});

$em->register('search',[searchEventHandler::class]);
return $em;