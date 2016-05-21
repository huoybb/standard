<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/11
 * Time: 21:29
 */
class taggablesEventsHandler
{
    public function whenaddCommentEvent(addCommentEvent $event)
    {
        $object = $event->object;
        if(is_subclass_of($object,Taggables::class)){
            /** @var Taggables $object */
            $tagged = $object->getTagged();
            if(property_exists($tagged,'commentCount')) $tagged->increaseCount('commentCount');
            $object->tag()->save();//刷新一下时间戳updated_at
        }
    }

}