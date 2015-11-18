<?php

class Attachments extends myModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $url;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $file_id;

    /**
     *
     * @var integer
     */
    public $user_id;

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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("'Attachments'");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Attachments';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Attachments[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Attachments
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
            'name' => 'name',
            'url' => 'url',
            'description' => 'description',
            'file_id' => 'file_id',
            'user_id' => 'user_id',
            'updated_at' => 'updated_at',
            'created_at' => 'created_at'
        );
    }

    public function getFileSize()
    {
        return $this->make('fileSize',function(){
            return filesize($this->url);
        });
    }

    public function beforeDelete()
    {
        //删除附件的实体文件，避免出现死文件
        unlink($this->url);
    }



}
