<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 11:31
 */
class searchEvent
{
    public $keywords;
    /**
     * @var Users
     */
    public $user;

    /**
     * searchEvent constructor.
     * @param $search
     * @param mixed $getService
     */
    public function __construct($kewords, Users $user)
    {
        $this->keywords = $kewords;
        $this->user = $user;
    }
}