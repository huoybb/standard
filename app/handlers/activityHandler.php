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

    /**
     * @param $event
     * @param myModel $object
     * @param Attachments[] $files
     */
    public function addAttachment($event, myModel $object, array $files)
    {
        if(method_exists($object,'increaseCount')) $object->increaseCount('attachmentCount',count($files));

        if(is_a($object,'Tags')) $object->updateTagMeta();

        foreach($files as $attachment){
            Subscriber::notify($object,Activity::addAttachment($object,$attachment,AuthFacade::getService()));
        }
    }

    public function deleteAttachment($event, myModel $object)
    {
        if(method_exists($object,'decreaseCount')) $object->decreaseCount('attachmentCount');
    }

}