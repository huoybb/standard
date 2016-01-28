<?php
$em = new myEventManager();

$em->attach('auth',new authEventsHandler());

$em->listen('tags:updateTag',cacheEventsHandler::class.'::deleteTagsCache');
$em->listen('tags:updateTag',tagsEventsHandler::class.'::updateMeta');

$em->attach('taggables',new taggablesEventsHandler());

$em->attach('standards:addWebFile',function($event,\Phalcon\Mvc\Model $model){
    redisFacade::delete('standard:archives:'.get_class($model));
    redisFacade::delete('standard:archives:Files');
});
$em->attach('standards:addFile',function($event,$model){
    redisFacade::delete('standard:archives:Files');
});

return $em;