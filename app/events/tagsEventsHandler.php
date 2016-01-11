<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/11
 * Time: 21:00
 * 这种方式便于将事件才分开来，也容易调试相应的专门的事项
 */
class tagsEventsHandler
{

    public function deleteTagsCache()
    {
        $redis = \Phalcon\Di::getDefault()->get('redis');
        $redis->deleteTags();
    }
    public function updateMeta($event,Tags $tag)
    {
        $meta = $tag->getTagmetaOrNew();
        if($meta->id) $meta->save();
    }
}