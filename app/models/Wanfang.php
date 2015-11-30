<?php

class Wanfang extends \Phalcon\Mvc\Model implements FileableInterface
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
    public $title;
    /**
     *
     * @var string
     */
    public $wanfangId;

    /**
     *
     * @var string
     */
    public $english_title;

    /**
     *
     * @var string
     */
    public $abstract;

    /**
     *
     * @var string
     */
    public $doi;

    /**
     *
     * @var string
     */
    public $Personal_Author;

    /**
     *
     * @var string
     */
    public $Corporate_Author;

    /**
     *
     * @var string
     */
    public $Journal;

    /**
     *
     * @var string
     */
    public $yearMonthNumber;

    /**
     *
     * @var string
     */
    public $keywords;

    /**
     *
     * @var string
     */
    public $publishDate;

    /**
     *
     * @var integer
     */
    public $file_id;

    /**
     * @param $wanfangId
     * @return Wanfang
     */
    public static function findBySourceId($souceId)
    {
        return self::query()
            ->where('wanfangId = :id:',['id'=>$souceId])
            ->execute()->getFirst();
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'wanfang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Wanfang[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Wanfang
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
            'title' => 'title',
            'wanfangId' => 'wanfangId',
            'english_title' => 'english_title',
            'abstract' => 'abstract',
            'doi' => 'doi',
            'Personal_Author' => 'Personal_Author',
            'Corporate_Author' => 'Corporate_Author',
            'Journal' => 'Journal',
            'yearMonthNumber' => 'yearMonthNumber',
            'keywords' => 'keywords',
            'publishDate' => 'publishDate',
            'file_id' => 'file_id'
        );
    }
    public function format()
    {
        return [
            'doi' => 'doi',
            'english_title' => 'title',
            'Corporate_Author'=>'单位',
            'Personal_Author'=>'作者',
            'Journal' => '刊名',
            'yearMonthNumber' => '年，卷(期)',
            'abstract'=>'摘要',
            'keywords' => '关键词',
        ];
    }

    public function getType()
    {
        return '期刊';
    }
}
