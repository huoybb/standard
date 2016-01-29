<?php

class Link extends myModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $url;

    /**
     *
     * @var string
     */
    public $note;

    /**
     *
     * @var string
     */
    public $linkable_type;

    /**
     *
     * @var integer
     */
    public $linkable_id;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'link';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Link[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Link
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
            'url' => 'url',
            'note' => 'note',
            'linkable_type' => 'linkable_type',
            'linkable_id' => 'linkable_id',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'user_id' => 'user_id'
        );
    }

    public function getSiteName($url=null)
    {
        if($url == null) $url = $this->url;
        $siteName = '链接';
        if(preg_match('%http://d.wanfangdata.com.cn/%m', $url)) $siteName = '万方';
        if(preg_match('%http://www.pv265.com/%m', $url)) $siteName = 'PV265';
        if(preg_match('%http://oai.dtic.mil/%m', $url)) $siteName = 'OAI';
        if(preg_match('%http://www.doc88.com/%m', $url)) $siteName = '道客巴巴';
        if(preg_match('%http://www.cnki.com.cn/%m', $url)) $siteName = '知网';
        if(preg_match('%http://xueshu.baidu.com/%m', $url)) $siteName = '百度学术';
        if(preg_match('%http://www.docin.com/%m', $url)) $siteName = '豆丁';
        if(preg_match('%http://www.cqvip.com/%m', $url)) $siteName = '维普';
        if(preg_match('%http://wenku.baidu.com/%m', $url)) $siteName = '百度文库';
        if(preg_match('%http://baike.baidu.com/%m', $url)) $siteName = '百度百科';
        return $siteName;
    }
    public function getUser()
    {
        return Users::findFirst($this->user_id);
    }



}
