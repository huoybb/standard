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

    public static function addComment(myModel $subject, Comments $comment, Users $user)
    {
        return self::prepareActivity($subject,$user, json_encode(['type' => 'addComment', 'comment_id' => $comment->id]));
    }

    public static function addAttachment(myModel $subject, Attachments $attachment, Users $user){
        return self::prepareActivity($subject,$user, json_encode(['type'=>'addAttachment','attachment_id'=>$attachment->id]));
    }

    public static function addFileList(myModel $subject, array $fileIds, Users $user){
        return self::prepareActivity($subject,$user, json_encode(['type'=>'addFileList','fileIds'=>$fileIds]));
    }


    /**
     * @param myModel $subject //在那个主题下，tag或者file下？或者说领域下
     * @param Users $user  //谁来做的活动？
     * @param $doing   //干了什么事
     * @return static
     */
    public static function prepareActivity(myModel $subject, Users $user, $doing )
    {
        $activity = new static;
        $activity->user_id = $user->id;
        $activity->object_id = $subject->id;
        $activity->object_type = get_class($subject);
        $activity->doing = $doing;
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
