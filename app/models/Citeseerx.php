<?php

class Citeseerx extends \Phalcon\Mvc\Model implements FileableInterface
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
    public $authors;

    /**
     *
     * @var string
     */
    public $venue;

    /**
     *
     * @var string
     */
    public $citations;

    /**
     *
     * @var string
     */
    public $abstract;

    /**
     *
     * @var string
     */
    public $source_id;

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
        return 'citeseerx';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Citeseerx[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Citeseerx
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
            'authors' => 'authors',
            'venue' => 'venue',
            'citations' => 'citations',
            'abstract' => 'abstract',
            'source_id' => 'source_id',
            'file_id' => 'file_id'
        );
    }


    public function format()
    {
        return [
            'source_id' => '序列号',
            'authors' => 'authors',
            'venue' => 'venue',
            'citations' => 'citations',
            'abstract' => 'abstract',
        ];
    }
    public function getType()
    {
        return self::getDatabaseName();
    }

    public static function getDatabaseName()
    {
        return 'CiteSeerX';
    }
    public function getDBDescription()
    {
        return '(原名CiteSeer.IST)，是NEC研究院在自动引文索引(Autonomous Citation Indexing, ACI)机制的基础上建设的一个学术论文数字图书馆。这个引文索引系统提供了一种通过引文链接的检索文献的方式，目标是从多个方面促进学术文献的传播和反馈。CiteSeerX检索WEB上的PostScript和PDF两种格式的学术论文。目前，在CiteSeerX数据库中可检索超过6M篇论文，这些论文涉及的内容主要是计算机领域。这个系统能够在网上提供完全免费的服务(包括下载PostScript或PDF格式的论文的全文)。该系统的主要功能有：①检索相关文献，浏览并下载论文全文；②查看某一具体文献的“引用”与“被引”情况；③查看某一篇论文的相关文献；④图表显示某一主题文献(或某一作者、机构所发表的文献)的时间分布。';
    }
    public function getDBHomePageLink()
    {
        return 'http://citeseerx.ist.psu.edu/index';
    }
}
