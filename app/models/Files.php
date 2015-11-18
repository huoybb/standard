<?php

class Files extends myModel
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



    public function attachments()
    {
        return $this->make('attachments',function(){
            return Attachments::query()
                ->where('file_id = :id:',['id'=>$this->id])
                ->orderBy('created_at DESC')
                ->execute();
        });
    }



    public function tags()
    {

        return $this->make('tags',function(){
            return Taggables::query()
                ->leftJoin('Tags','Tags.id = Taggables.tag_id')
                ->where('Taggables.taggable_type = :type:',['type'=>get_class($this)])
                ->andWhere('Taggables.taggable_id = :id:',['id'=>$this->id])
                ->columns(['Tags.id','Tags.name','Taggables.updated_at','Taggables.id AS tid'])
                ->execute();
        });
    }

    public function getRevision()
    {
        return $this->make('revision',function(){
            return Revisions::findFirst(['file_id = :id:','bind'=>['id'=>$this->id]]);
        });
    }




    public function getNext()
    {
        return  $this->make('next',function(){
            $row = self::findFirst(['id > :id:','bind'=>['id'=>$this->id],'order'=>'id ASC']);
            if(null == $row) $row =self::findFirst();
            return $row;
        });
    }
    
    public function getPrevious()
    {
        return $this->make('before',function(){
            $row = self::findFirst(['id<:id:','bind'=>['id'=>$this->id],'order'=>'id DESC']);
            if(null == $row) $row = self::findFirst(['order'=>'id DESC']);
            return $row;
        });
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

    public function getAddCommentFormUrl()
    {
        return $this->getDI()->get('url')->get(['for'=>'standards.addComment','file'=>$this->id]);
    }








}
