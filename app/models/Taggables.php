<?php

class Taggables extends myModel
{

    /**
     *
     * @var integer
     */
    public $tag_id;

    /**
     *
     * @var integer
     */
    public $taggable_id;

    /**
     *
     * @var string
     */
    public $taggable_type;

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
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("'Taggables'");
        $this->belongsTo('tag_id', 'Tags', 'id', array('alias' => 'Tags'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Taggables';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Taggables[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Taggables
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
            'tag_id' => 'tag_id',
            'taggable_id' => 'taggable_id',
            'taggable_type' => 'taggable_type',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'id' => 'id',
            'user_id' => 'user_id'
        );
    }

    public function getTagged()
    {
        return $this->make('tagged',function(){
            $className = $this->taggable_type;
            return  $className::findFirst($this->taggable_id);
        });
    }

    /**
     * @return Tags
     */
    public function tag()
    {
        return $this->make('tag',function(){
            return Tags::findFirst($this->tag_id);
        });
    }



}
