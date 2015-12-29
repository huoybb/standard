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


    public static function getDatabaseName()
    {
        return 'EverySpec';
    }

    public function getDBDescription()
    {
        return 'EverySpec provides free access to over 50,000 Military, DoD, Federal, NASA, DOE, and Government specifications, standards, handbooks, and publications.

This data warehouse includes standardization documents with the designations of MIL, MIL-STD, MIL-PRF, MIL-DTL, FED, CID, JANS, MS, AND, USAF, DID, CID, UCF, and FIPS, including their Amendments, Notices, and Supplements.';
    }
    public function getDBHomePageLink(){
        return 'http://everyspec.com/';
    }
}
