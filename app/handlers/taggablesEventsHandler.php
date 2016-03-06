<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/11
 * Time: 21:29
 */
class taggablesEventsHandler
{
    public function addComment($event,Taggables $taggable)
    {
        $tagged = $taggable->getTagged();
        if(property_exists($tagged,'commentCount')) $tagged->increaseCount('commentCount');
        $taggable->tag()->save();//刷新一下时间戳updated_at
    }

}