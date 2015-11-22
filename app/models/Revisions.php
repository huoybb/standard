<?php

class Revisions extends myModel
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
    public $file_id;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     *
     * @var string
     */
    public $name;

    public $created_at;

    public $updated_at;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'revisions';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Revisions[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Revisions
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
            'file_id' => 'file_id',
            'parent_id' => 'parent_id',
            'name' => 'name',
            'updated_at'=>'updated_at',
            'created_at'=>'created_at'
        );
    }

    public function getAllRevisions()
    {
        return $this->make('AllRevisions',function(){
//            return self::find(['parent_id = :parent_id:','bind'=>['parent_id'=>$this->parent_id]]);
            return self::query()
                ->where('parent_id = :parent_id:',['parent_id'=>$this->parent_id])
                ->leftJoin('Files','file.id = Revisions.file_id','file')
                ->columns(['Revisions.*','file.*'])
                ->execute();
        });
    }


}
