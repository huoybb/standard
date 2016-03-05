<?php

class Subscriber extends myModel
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
    public $user_id;

    /**
     *
     * @var integer
     */
    public $object_id;
    /**
     *
     * @var string
     */
    public $object_type;

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
     * 通知主题tag下发生了什么事件activity
     * @param Tags $object
     * @param Activity $activity
     */
    public static function notify(myModel $object, Activity $activity)
    {
        $subscribers = Subscriber::query()
            ->where('object_id = :id:',['id'=>$object->id])
            ->andWhere('object_type =:type:',['type'=>get_class($object)])
            ->execute();
        foreach($subscribers as $subscriber){
            $data = [
                'activity_id'=>$activity->id,
                'user_id'=>$subscriber->user_id,
                'status'=>false,
            ];
            if($subscriber->user_id == AuthFacade::getID()) $data['status']=true;
            Notification::saveNew($data);
        }
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'subscriber';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Subscriber[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Subscriber
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
            'user_id' => 'user_id',
            'object_id' => 'object_id',
            'object_type' => 'object_type',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at'
        );
    }

}
