<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/6
 * Time: 6:23
 */
class activityHandler
{
    public function addComment($event,myModel $object,Comments $comment)
    {
        Subscriber::notify($object, Activity::addComment($object,$comment,AuthFacade::getService()));
    }

}