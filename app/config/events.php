<?php
$eventManager = new myEventManager();

$eDomain = \Phalcon\Di::getDefault()->get('config')->application->eventPrefix;

$eventManager->register($eDomain,[
    notificationHandler::class,
    searchLoghandler::class,
    authEventsHandler::class,
    cacheEventsHandler::class,
    tagsEventsHandler::class,//有这个必要吗？是否属于领域内的事情呢？
    taggablesEventsHandler::class,
]);

return $eventManager;