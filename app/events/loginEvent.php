<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 12:59
 */
class loginEvent
{
    /**
     * @var Users
     */
    public $user;
    /**
     * @var mixed
     */
    public $data;

    /**
     * loginEvent constructor.
     * @param Users $user
     * @param mixed $data
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }
}