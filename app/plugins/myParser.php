<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/30
 * Time: 19:53
 */
use Goutte\Client;
abstract class myParser
{
    function __construct()
    {
        $this->client = new Client();
    }
    abstract public function parseInfo($file_id);

}