<?php
$em = new myEventManager();

$em->attach('auth',new authEventsHandler());

$em->listen('tags:updateTag',cacheEventsHandler::class.'::deleteTagsCache');
$em->listen('tags:updateTag',tagsEventsHandler::class.'::updateMeta');

$em->attach('taggables',new taggablesEventsHandler());

return $em;