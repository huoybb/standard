<?php

class Tags extends myModel
{

    use commentableTrait;
    use attachableTrait;
    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

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
    public $commentCount;
    /**
     *
     * @var integer
     */
    public $taggableCount;
    /**
     *
     * @var integer
     */
    public $attachmentCount;

    public static function findOrNewByName($tagName)
    {
        $data['name'] = $tagName;
        $tag = self::findFirst(['name = :name:','bind'=>['name'=>$tagName]]);
        if($tag == null){
            $tag = new self();
            $tag->save($data);
        }
        return $tag;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("'Tags'");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Tags';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tags[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tags
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
            'name' => 'name',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'description' => 'description',
            'commentCount' => 'commentCount',
            'taggableCount' => 'taggableCount',
            'attachmentCount' => 'attachmentCount',
        );
    }


    public function tagCounts()
    {
        return $this->taggableCount;
    }

    public function taggables($type = null)
    {
        return $this->make('taggables',function() use($type) {
            $results = Taggables::query()
                ->where('tag_id = :tag:',['tag'=>$this->id])
                ->orderBy('updated_at DESC');
            if($type <> null){
                $results->andWhere('taggable_type = :type:',['type'=>$type]);
            }

            return $results->execute();
        });
    }

    public function getTaggedFiles()
    {
        return $this->make('files',function(){
            return Files::query()
                ->rightJoin('Taggables','Taggables.taggable_id = Files.id AND Taggables.taggable_type="Files"')
                ->where('Taggables.tag_id = :tag:',['tag'=>$this->id])
                ->columns(['Files.*','Taggables.*'])
                ->groupBy('Files.id')
                ->orderBy('Taggables.created_at DESC')
                ->execute();

        });
    }


    public function addFileList(array $file_ids)
    {
        $files = Files::query()
            ->inWhere('id',$file_ids)
            ->execute();
        foreach($files as $file){
            /** @var Files $file */
            $file->addTag($this);
        }
        return $this;
    }


}
