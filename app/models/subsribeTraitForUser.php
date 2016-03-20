<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/9
 * Time: 22:44
 */
trait SubsribeTraitForUser
{
    /**
     * @return Phalcon\Mvc\Model\Resultset\Complex
     */
    public function getNotifications(){
        /** @var Users $this */
        return $this->make(
            'notifications',function(){
            /** @var Users $this */
            return Notification::getNotificationsForUser($this);
        });
    }

    /**获取当前用户的未读通知项目
     * @return Phalcon\Mvc\Model\Resultset\Complex
     */
    public function getUnreadNotifications()
    {
        /** @var Users $this */
        return $this->make('unreadNotifications',function(){
            /** @var Users $this */
            return Notification::getUnreadNotificationsForUser($this);
        });
    }

    /**
     * @param Notification $notification
     * @return bool
     */
    public function readNotification(Notification $notification)
    {
        return $notification->save(['status'=>true]);
    }

    /**
     * @param Notification $notification
     * @return string
     */
    public function getNotificationObjectType(Notification $notification)
    {
        return $notification->getActivity()->object_type;
    }
    


    /**
     * @return Subscriber[]
     * @todo 需要进一步的完善，看看是否直接将file和tag查询出来，避免后续的查询每一个object
     */
    public function getSubscribedObjects()
    {
        return Subscriber::query()
            ->where('user_id = :user:',['user'=>$this->id])
            ->execute();
    }

    /**
     * @param myModel $object
     * @return boolean
     */
    public function isSubscribedTo(myModel $object)
    {
        /** @var Users $this */
        return Subscriber::query()
            ->where('user_id = :user:',['user'=>$this->id])
            ->andWhere('object_id = :id:',['id'=>$object->id])
            ->andWhere('object_type = :type:',['type'=>get_class($object)])
            ->execute()->count() > 0;
    }

    /**
     * @param myModel $object
     * @return Users
     */
    public function subscribe(myModel $object)
    {
        /** @var Users $this */
        if(!$this->isSubscribedTo($object)) {
            Subscriber::saveNew(['user_id'=>$this->id,'object_id'=>$object->id,'object_type'=>get_class($object)]);
        }
        return $this;
    }

    /**
     * @param myModel $object
     * @return Users
     */
    public function unsubscribe(myModel $object)
    {
        /** @var Users $this */
        if($this->isSubscribedTo($object)){
            $rows = Subscriber::query()
                ->where('user_id = :user:',['user'=>$this->id])
                ->andWhere('object_id = :id:',['id'=>$object->id])
                ->andWhere('object_type = :type:',['type'=>get_class($object)])
                ->execute();
            $rows->delete();
        }
        return $this;
    }

}