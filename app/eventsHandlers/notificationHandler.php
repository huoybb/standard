<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 7:39
 */
class notificationHandler
{
    public function whenaddCommentEvent(addCommentEvent $event)
    {
        $activity = Activity::addComment($event->object, $event->comment, AuthFacade::getService());
        Subscriber::notify($event->object, $activity);
    }

    public function whenaddAttachmentEvent(addAttachmentEvent $event)
    {
        foreach($event->files as $attachment){
            Subscriber::notify($$event->object,Activity::addAttachment($event->object,$attachment,AuthFacade::getService()));
        }
    }

    public function whenaddFilelistToTagEvent(addFilelistToTagEvent $event)
    {
        $fileIds = $event->file_ids;
        $tag = $event->tag;
        Subscriber::notify($tag,Activity::addFileList($tag,$fileIds,AuthFacade::getService()));
    }

}