<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/11
 * Time: 17:13
 */
class authEventsHandler
{
    public function login($event,Users $user,$data)
    {
        $remember = isset($data['remember'])?$data['remember']:'off';
        (new IsLoginValidator())->registerSession($user,$remember);
    }

    public function logout($event,$controller)
    {
        (new IsLoginValidator())->destroySession();
    }

}