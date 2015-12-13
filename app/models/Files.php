<?php

class Files extends myModel
{

    use attachableTrait;
    use commentableTrait;
    use taggableTrait;
    use navTrait;
    use revisionableTrait;
    use FileableTrait;
    use LinkableTrait;
    use countForRootClassTrait;
    use RelationshipTrait;
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
    public $url;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $standard_number;

    /**
     *
     * @var string
     */
    public $updated_at_website;
    /**
     *
     * @var integer
     */
    public $commentCount;
    /**
     *
     * @var integer
     */
    public $attachmentCount;

    /**
     *
     * @var integer
     */
    public $linkCount;
    /**
     *
     * @var string
     */
    public $type;
    /**
     *
     * @var integer
     */
    public $relationCount;


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("'Files'");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Files';
    }



    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Files[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Files
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
            'url' => 'url',
            'updated_at' => 'updated_at',
            'created_at' => 'created_at',
            'standard_number' => 'standard_number',
            'updated_at_website' => 'updated_at_website',
            'commentCount' => 'commentCount',
            'attachmentCount' => 'attachmentCount',
            'linkCount' => 'linkCount',
            'type' => 'type',
            'relationCount' => 'relationCount',
        );
    }

    public function getHtml($key)
    {
        if(!$this->$key) return null;
        if($key == 'url'){
            $siteName = '链接';
            if(preg_match('%http://d.wanfangdata.com.cn/%m', $this->$key)) $siteName = '万方';
            if(preg_match('%http://www.pv265.com/%m', $this->$key)) $siteName = 'PV265';
            if(preg_match('%http://oai.dtic.mil/%m', $this->$key)) $siteName = 'OAI';
            if(preg_match('%http://everyspec.com/%m', $this->$key)) $siteName = 'EverySpec';
            return '<a href="'.$this->$key.'" target="_blank" >'.$siteName.'</a>';
        }

        return $this->$key;
    }

    public function search($search)
    {
        $bits = explode(' ',trim($search));
        $results = $this->query()->orderBy('id')->where('title like :search:',['search'=>'%'.array_shift($bits).'%']);

        foreach($bits as $key => $bit){
            $results->andWhere("title like :search{$key}:",["search{$key}"=>'%'.$bit.'%']);
        }
        return $results->execute();
    }

    /**这种形式能够在取出部分的时候速度比较快！
     * @param $search
     * @return \Phalcon\Mvc\Model\Query\BuilderInterface
     */
    static public function searchQuery($search)
    {
        $bits = explode(' ',trim($search));
        $builder = (new self)->getModelsManager()->createBuilder()
            ->from(self::class)
            ->orderBy('id DESC')
            ->where('title like :search:',['search'=>'%'.array_shift($bits).'%']);
        foreach($bits as $key=>$bit){
            $builder->andWhere("title like :search{$key}:",["search{$key}"=>'%'.$bit.'%']);
        }
        return $builder;
    }

    /**
     * @param $search
     * @return Files
     */
    public static function findByStandardNumber($search)
    {
        return self::query()
            ->where('standard_number = :SN:',['SN'=>$search])
            ->execute()
            ->getFirst();
    }

}
