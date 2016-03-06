<?php
$eventManager = new myEventManager();

$eventManager->listen('auth:login',authEventsHandler::class.'::login');
$eventManager->listen('auth:logout',authEventsHandler::class.'::logout');

$eventManager->listen('search:main',searchEventHandler::class.'::main');
$eventManager->listen('search:sub',searchEventHandler::class.'::sub');

$eventManager->listen('tags:updateTag',cacheEventsHandler::class.'::deleteTagsCache');
$eventManager->listen('tags:updateTag',tagsEventsHandler::class.'::updateMeta');

$eventManager->listen('tags:addComment',activityHandler::class.'::addComment');
$eventManager->listen('files:addComment',activityHandler::class.'::addComment');

$eventManager->listen('taggables:addComment',taggablesEventsHandler::class.'::addComment');

$eventManager->listen('standards:addWebFile',standardHandler::class.'::addWebFile');
$eventManager->listen('standards:addFile',standardHandler::class.'::addFile');

$eventManager->listen('standards:deleteFile',standardHandler::class.'::deleteFile');
$eventManager->listen('standards:deleteSelectedFiles',standardHandler::class.'::deleteSelectedFiles');

return $eventManager;