<?php

class Notification extends myModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $activity_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     * @param Users $user
     * @return Phalcon\Mvc\Model\Resultset\Complex
     */

    public static function getNotificationsForUser(Users $user)
    {
        return self::getNotificationQueryForUser($user)
            ->getQuery()->execute();
    }

    public static function getUnreadNotificationsForUser(Users $user){
        return self::getNotificationQueryForUser($user)
            ->andWhere('status = :status:',['status'=>false])
            ->getQuery()->execute();
    }

    /**
     * @param Users $user
     * @return mixed
     */
    public static function getNotificationQueryForUser(Users $user)
    {
        return ModelsManager::createBuilder()
            ->from(['notify' => Notification::class])
            ->leftJoin(Activity::class, 'act.id = notify.activity_id', 'act')
            ->leftJoin(Users::class, 'act.user_id = user.id', 'user')
            ->leftJoin(Tags::class, 'tag.id = act.object_id AND act.object_type ="Tags"', 'tag')
            ->leftJoin(Files::class, 'file.id = act.object_id AND act.object_type ="Files"', 'file')
            ->where('notify.user_id = :user:', ['user' => $user->id])
            ->orderBy('notify.id DESC')
//            ->andWhere('status = :status:',['status'=>false])
            ->columns(['act.*', 'notify.*', 'user.*', 'tag.*','file.*']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'notification';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notification[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Notification
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'activity_id' => 'activity_id',
            'user_id' => 'user_id',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'status' => 'status'
        );
    }

    public function getActivity()
    {
        return Activity::findFirst($this->activity_id);
    }
    
    public function isDone()
    {
        return !$this->status;
    }

    public function getTagID()
    {
        return $this->getActivity()->object_id;
    }

    



}
