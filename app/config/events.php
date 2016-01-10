<?php
$em = new \Phalcon\Events\Manager();

$em->attach('auth:login',function($event,Users $user,$data){
    $remember = isset($data['remember'])?$data['remember']:'off';
    (new IsLoginValidator())->registerSession($user,$remember);
});
$em->attach('auth:logout',function($event,$controller){
    (new IsLoginValidator())->destroySession();
});
$em->attach('tags:updateTag',function($event,Tags $tag){
    $redis = \Phalcon\Di::getDefault()->get('redis');
    $redis->deleteTags();
    $meta = $tag->getTagmetaOrNew();
    $meta->save();

});
return $em;