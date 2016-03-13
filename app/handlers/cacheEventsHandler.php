<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/12
 * Time: 6:15
 */
class cacheEventsHandler
{

    public function deleteTagsCache()
    {
        TagsCacheFacade::deleteTags();
    }
}