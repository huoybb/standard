<?php
$em = new \Phalcon\Events\Manager();

$em->attach('auth',new authEventsHandler());
$em->attach('tags:updateTag',function($event,Tags $tag){
    $redis = \Phalcon\Di::getDefault()->get('redis');
    $redis->deleteTags();

    $meta = $tag->getTagmetaOrNew();
    if($meta->id) $meta->save();

});
return $em;