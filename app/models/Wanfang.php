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
    public $source_id;

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
     * @param $sourceId
     * @return Wanfang
     */
    public static function findBySourceId($souceId)
    {
        return self::query()
            ->where('source_id = :id:',['id'=>$souceId])
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
            'source_id' => 'source_id',
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

    public static function getDatabaseName()
    {
        return '万方期刊';
    }

    public function getDBDescription()
    {
        return '《中国学术期刊数据库》（China Science Periodical Database，CSPD）,收录始于1998年,7600余种，核心刊3000种，年增300万篇，周更新2次,涵盖理、工、农、医、经济、教育、文艺、社科、哲学政法等学科,全部拥有国内统一连续出版物号,免费注册DOI。';
    }

    public function getDBHomePageLink()
    {
        return 'http://www.wanfangdata.com.cn/';
    }
}
