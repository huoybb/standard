<?php
$em = new myEventManager();

$em->attach('auth',new authEventsHandler());

$em->listen('tags:updateTag',tagsEventsHandler::class.'::deleteTagsCache');
$em->listen('tags:updateTag',tagsEventsHandler::class.'::updateMeta');

return $em;