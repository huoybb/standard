<?php

class Tagmetas extends myModel
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
    public $tag_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $commentCount;

    /**
     *
     * @var integer
     */
    public $taggableCount;

    /**
     *
     * @var integer
     */
    public $attachmentCount;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var integer
     */
    public $linkCount;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tagmetas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tagmetas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tagmetas
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
            'tag_id' => 'tag_id',
            'user_id' => 'user_id',
            'description' => 'description',
            'commentCount' => 'commentCount',
            'taggableCount' => 'taggableCount',
            'attachmentCount' => 'attachmentCount',
            'updated_at' => 'updated_at',
            'created_at' => 'created_at',
            'linkCount' => 'linkCount'
        );
    }

    /**
     * @return Tags
     */
    public function getTag()
    {
        return Tags::findFirst($this->tag_id);
    }


}
