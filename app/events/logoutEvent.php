<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 13:24
 */
class logoutEvent
{
    /**
     * @var Users
     */
    public $user;

    /**
     * logoutEvent constructor.
     * @param mixed $getService
     */
    public function __construct(Users $user)
    {
        $this->user = $user;
    }
}