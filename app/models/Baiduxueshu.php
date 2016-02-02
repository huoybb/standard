<?php

class Baiduxueshu extends \Phalcon\Mvc\Model implements FileableInterface
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
    public $writer;

    /**
     *
     * @var string
     */
    public $abstract;

    /**
     *
     * @var string
     */
    public $publisher;

    /**
     *
     * @var string
     */
    public $keywords;

    /**
     *
     * @var integer
     */
    public $cited;

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
        return 'baiduxueshu';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Baiduxueshu[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Baiduxueshu
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
            'writer' => 'writer',
            'abstract' => 'abstract',
            'publisher' => 'publisher',
            'keywords' => 'keywords',
            'cited' => 'cited',
            'file_id' => 'file_id'
        );
    }

    public function format()
    {
        return [
            'title'=>'标题',
            'writer'=>'作者',
            'abstract'=>'摘要',
            'publisher'=>'出版源',
            'keywords'=>'关键词',
            'cited'=>'引用量'
        ];
    }

    public function getType()
    {
        return '百度学术';
    }

    public static function getDatabaseName()
    {
        return '百度学术';
    }

    public function getDBDescription()
    {
        return '百度学术搜索，是一个提供海量中英文文献检索的学术资源搜索平台，涵盖了各类学术期刊、会议论文，旨在为国内外学者提供最好的科研体验。';
    }

    public function getDBHomePageLink()
    {
        return 'http://xueshu.baidu.com/';
    }
}
