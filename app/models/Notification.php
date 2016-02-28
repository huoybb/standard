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

    public static function getNotificationsForUser(Users $user)
    {
        return ModelsManager::createBuilder()
            ->from(['notify'=>Notification::class])
            ->leftJoin(Activity::class,'act.id = notify.activity_id','act')
            ->where('notify.user_id = :user:',['user'=>$user->id])
            ->andWhere('status = :status:',['status'=>false])
            ->columns(['act.*','notify.*'])
            ->getQuery()->execute();
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

}
