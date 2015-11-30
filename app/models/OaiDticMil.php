<?php

class OaiDticMil extends \Phalcon\Mvc\Model implements FileableInterface
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
    public $Accession_Number;

    /**
     *
     * @var string
     */
    public $Title;

    /**
     *
     * @var string
     */
    public $Descriptive_Note;

    /**
     *
     * @var string
     */
    public $Corporate_Author;

    /**
     *
     * @var string
     */
    public $Personal_Author;

    /**
     *
     * @var string
     */
    public $PDF_Url;

    /**
     *
     * @var string
     */
    public $Report_Date;

    /**
     *
     * @var integer
     */
    public $Pagination_or_Media_Count;

    /**
     *
     * @var string
     */
    public $Abstract;

    /**
     *
     * @var string
     */
    public $Descriptors;

    /**
     *
     * @var string
     */
    public $Subject_Categories;

    /**
     *
     * @var string
     */
    public $Distribution_Statement;

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
        return 'oai_dtic_mil';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OaiDticMil[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OaiDticMil
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
            'Accession_Number' => 'Accession_Number',
            'Title' => 'Title',
            'Descriptive_Note' => 'Descriptive_Note',
            'Corporate_Author' => 'Corporate_Author',
            'Personal_Author' => 'Personal_Author',
            'PDF_Url' => 'PDF_Url',
            'Report_Date' => 'Report_Date',
            'Pagination_or_Media_Count' => 'Pagination_or_Media_Count',
            'Abstract' => 'Abstract',
            'Descriptors' => 'Descriptors',
            'Subject_Categories' => 'Subject_Categories',
            'Distribution_Statement' => 'Distribution_Statement',
            'file_id' => 'file_id'
        );
    }
    /**
     * @param $souceId
     * @return OaiDticMil
     */
    public static function findBySourceId($souceId)
    {
        return self::query()
            ->where('Accession_Number = :Accession_Number:',['Accession_Number'=>$souceId])
            ->execute()->getFirst();
    }




    public function format()
    {
        return [
            'Accession_Number'=>'序列号',
            'Descriptive_Note'=>'文档类型',
            'Corporate_Author'=>'单位',
            'Personal_Author'=>'作者',
            'Pagination_or_Media_Count'=>'页数',
            'Abstract'=>'摘要',
            'Descriptors'=>'描述分类',
            'Subject_Categories'=>'主题分类'
        ];
    }
    public function getType()
    {
        return '美军';
    }

}
