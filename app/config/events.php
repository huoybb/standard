<?php
$em = new \Phalcon\Events\Manager();

$em->attach('auth:login',function($event,Users $user,$data){
    $remember = isset($data['remember'])?$data['remember']:'off';
    (new IsLoginValidator())->registerSession($user,$remember);
});
$em->attach('auth:logout',function($event,$controller){
    (new IsLoginValidator())->destroySession();
});
return $em;