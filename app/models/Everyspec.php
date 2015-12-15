<?php

class Everyspec extends \Phalcon\Mvc\Model implements FileableInterface
{
    use FileableInterfaceTrait;
    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $source_id;
    /**
     *
     * @var string
     */
    public $standard_no;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $date;

    /**
     *
     * @var string
     */
    public $abstract;

    /**
     *
     * @var integer
     */
    public $file_id;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'everyspec';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Everyspec[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Everyspec
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
            'source_id' => 'source_id',
            'standard_no' => 'standard_no',
            'title' => 'title',
            'date' => 'date',
            'abstract' => 'abstract',
            'file_id' => 'file_id'
        );
    }



    public function format()
    {
        return [
            'standard_no' => '标准编号',
            'title' => '标准名称',
            'date'=>'发布日期',
            'abstract'=>'摘要',
        ];
    }


    public function getType()
    {
        return 'EverySpec';
    }

    /**
     * @param $file_id
     * @return Everyspec
     */
    public static function findBySourceId($source_id)
    {
        return self::query()
            ->where('source_id = :id:',['id'=>$source_id])
            ->execute()->getFirst();
    }


    public static function getDatabaseName()
    {
        return 'EverySpec';
    }
}
