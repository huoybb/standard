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
    public $tag_id;

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

    public static function addComment(Tags $tag, Comments $comment, Users $user)
    {
        $activity = new static;
        $activity->user_id = $user->id;
        $activity->tag_id = $tag->id;
        $activity->doing = json_encode(['type'=>'addComment','comment_id'=>$comment->id]);
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
            'tag_id' => 'tag_id',
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
