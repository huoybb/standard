<?php

class Files extends myModel
{

    use attachableTrait;
    use commentableTrait;
    use taggableTrait;
    use navTrait;
    use revisionableTrait;
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
            'updated_at_website' => 'updated_at_website'
        );
    }

    public function getHtml($key)
    {
        if($key == 'url'){
            return '<a href="'.$this->$key.'" target="_blank" >链接</a>';
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
    public function searchQuery($search)
    {
        $bits = explode(' ',trim($search));
        $builder = $this->getModelsManager()->createBuilder()
            ->from('Files')
            ->orderBy('id DESC')
            ->where('title like :search:',['search'=>'%'.array_shift($bits).'%']);
        foreach($bits as $key=>$bit){
            $builder->andWhere("title like :search{$key}:",["search{$key}"=>'%'.$bit.'%']);
        }
        return $builder;
    }















//事件绑定，下面是设置各种绑定事件的

    public function beforeDelete()
    {
        foreach($this->comments() as $c){$c->delete();}

        foreach($this->attachments() as $a){$a->delete();}

        $tags = Taggables::query()
            ->where('Taggables.taggable_type = :type:',['type'=>get_class($this)])
            ->andWhere('Taggables.taggable_id = :id:',['id'=>$this->id])
            ->execute();
        foreach($tags as $t){$t->delete();}

    }









}
