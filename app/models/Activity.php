<?php

class Activity extends myModel
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
    public $doing;

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

    public static function addComment(myModel $object, Comments $comment, Users $user)
    {
        $activity = new static;
        $activity->user_id = $user->id;
        $activity->object_id = $object->id;
        $activity->object_type = get_class($object);
        $activity->doing = json_encode(['type'=>'addComment','comment_id'=>$comment->id]);
        $activity->save();
        return $activity;
    }

    public static function addAttachment(myModel $object, Attachments $attachment, Users $user){
        $activity = new static;
        $activity->user_id = $user->id;
        $activity->object_id = $object->id;
        $activity->object_type = get_class($object);
        $activity->doing = json_encode(['type'=>'addAttachment','attachment_id'=>$attachment->id]);
        $activity->save();
        return $activity;
    }

    public static function addFileList(myModel $model,array $fileIds,Users $user){
        $activity = new static;
        $activity->user_id = $user->id;
        $activity->object_id = $model->id;
        $activity->object_type = get_class($model);
        $activity->doing = json_encode(['type'=>'addFileList','fileIds'=>$fileIds]);
        $activity->save();
        return $activity;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'activity';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Activity[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Activity
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
            'doing' => 'doing',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at'
        );
    }
    public function getTag()
    {
        return Tags::findFirst($this->tag_id);
    }

    public function getUser()
    {
        return Users::findFirst($this->user_id);
    }

    public function showDoing()
    {
        $doing = (array)json_decode($this->doing);
        if($doing['type'] == 'addComment') return '评论';
        return $this->doing;
    }




}
