<?php

class Wanfangthesis extends \Phalcon\Mvc\Model implements FileableInterface
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
    public $major;

    /**
     *
     * @var string
     */
    public $degree;

    /**
     *
     * @var string
     */
    public $school;

    /**
     *
     * @var string
     */
    public $supervisor;

    /**
     *
     * @var string
     */
    public $year;

    /**
     *
     * @var string
     */
    public $publishDate;

    /**
     *
     * @var string
     */
    public $keywords;

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
        return 'wanfangthesis';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Wanfangthesis[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Wanfangthesis
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * @param $wanfangId
     * @return Wanfangthesis
     */
    public static function findBySourceId($souceId)
    {
        return self::query()
            ->where('source_id = :id:',['id'=>$souceId])
            ->execute()->getFirst();
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
            'title' => 'title',
            'abstract' => 'abstract',
            'doi' => 'doi',
            'Personal_Author' => 'Personal_Author',
            'major' => 'major',
            'degree' => 'degree',
            'school' => 'school',
            'supervisor' => 'supervisor',
            'year' => 'year',
            'publishDate' => 'publishDate',
            'keywords' => 'keywords',
            'file_id' => 'file_id'
        );
    }


    public function format()
    {
        return [
            'doi' => 'doi',
            'Personal_Author'=>'作者',
            'major' => '学科专业',
            'degree' => '授予学位',
            'school' => '学位授予单位',
            'supervisor' => '导师姓名',
            'year' => '学位年度',
            'abstract'=>'摘要',
            'keywords' => '关键词',
        ];
    }

    public function getType()
    {
        return '学位';
    }
}
