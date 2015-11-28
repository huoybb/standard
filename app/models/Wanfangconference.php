<?php

class Wanfangconference extends \Phalcon\Mvc\Model implements FileableInterface
{

    /**
     *
     * @var integer
     */
    public $id; /**
     *
     * @var integer
     */
    public $file_id;

    /**
     *
     * @var string
     */
    public $wanfangId;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $abstract;

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
    public $parent_literature;

    /**
     *
     * @var string
     */
    public $conference_title;

    /**
     *
     * @var string
     */
    public $conference_date;

    /**
     *
     * @var string
     */
    public $conference_place;

    /**
     *
     * @var string
     */
    public $host_unit;

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
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'wanfangconference';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Wanfangconference[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Wanfangconference
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
            'wanfangId' => 'wanfangId',
            'title' => 'title',
            'abstract' => 'abstract',
            'Personal_Author' => 'Personal_Author',
            'Corporate_Author' => 'Corporate_Author',
            'parent_literature' => 'parent_literature',
            'conference_title' => 'conference_title',
            'conference_date' => 'conference_date',
            'conference_place' => 'conference_place',
            'host_unit' => 'host_unit',
            'keywords' => 'keywords',
            'publishDate' => 'publishDate',
            'file_id' => 'file_id'
        );
    }

    public function getStandard()
    {
        return Files::findFirst($this->file_id);
    }

    public function format()
    {
        return [
            'Personal_Author'=>'作者',
            'Corporate_Author' => '作者单位',
            'parent_literature' => '母体文献',
            'conference_title' => '会议名称',
            'conference_date' => '会议时间',
            'conference_place' => '会议地点',
            'host_unit' => '主办单位',
            'abstract'=>'摘要',
            'keywords' => '关键词',
        ];
    }

    public function getHtml($key)
    {
        if($key == 'abstract'){
            if($this->$key == null) return null;
            return '<pre>'.$this->$key.'</pre>';
        }
        return $this->$key;
    }
    public static function findBySourceId($souceId)
    {
        return self::query()
            ->where('wanfangId = :id:',['id'=>$souceId])
            ->execute()->getFirst();
    }


    public function getType()
    {
        return '会议';
    }
}
