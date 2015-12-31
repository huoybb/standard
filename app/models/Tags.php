<?php

class Tags extends myModel
{

    use commentableTrait;
    use attachableTrait;
    use countForRootClassTrait;
    use RelationshipTrait;
    use StatisticsTrait;
    use timeableTrait;
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
            $user  = \Phalcon\Di::getDefault()->get('auth');
            return Files::query()
                ->rightJoin('Taggables','Taggables.taggable_id = Files.id AND Taggables.taggable_type="Files"')
                ->where('Taggables.tag_id = :tag:',['tag'=>$this->id])
                ->andWhere('Taggables.user_id = :user:',['user'=>$user->id])
                ->columns(['Files.*','Taggables.*'])
                ->groupBy('Files.id')
                ->orderBy('Taggables.created_at DESC')//按照生成的时间排序，如果按照更新的时间排序，则会出现不稳定的现象，这个问题在多人一同操作的时候可能会发生，需要避免的
                ->execute();

        });
    }

    public function getTaggedFilesByMonth($month)
    {
        return $this->make('files',function() use($month){
            list($startTime,$endTime) = myTools::getBetweenTimes($month);
            $user = \Phalcon\Di::getDefault()->get('auth');
            return Files::query()
                ->rightJoin('Taggables','Taggables.taggable_id = Files.id AND Taggables.taggable_type="Files"')
                ->where('Taggables.tag_id = :tag:',['tag'=>$this->id])
                ->andWhere('Taggables.created_at > :start:',['start'=>$startTime->toDateTimeString()])
                ->andWhere('Taggables.created_at < :end:',['end'=>$endTime->toDateTimeString()])
                ->andWhere('Taggables.user_id = :user:',['user'=>$user->id])
                ->columns(['Files.*','Taggables.*'])
                ->groupBy('Files.id')
                ->orderBy('Taggables.created_at DESC')//按照生成的时间排序，如果按照更新的时间排序，则会出现不稳定的现象，这个问题在多人一同操作的时候可能会发生，需要避免的
                ->execute();

        });
    }

    public function getArchiveStatisticsByMonth()
    {
        $user = \Phalcon\Di::getDefault()->get('auth');
        $query = Files::query()
            ->rightJoin('Taggables','Taggables.taggable_id = Files.id AND Taggables.taggable_type="Files"')
            ->where('Taggables.tag_id = :tag:',['tag'=>$this->id])
            ->andWhere('Taggables.user_id = :user:',['user'=>$user->id])
            ->columns(['count(Files.id) AS num','DATE_FORMAT(Taggables.created_at,"%Y-%m") As month'])
            ->groupBy('month')
            ->orderBy('month DESC');
        return $query
            ->execute();
    }

    public function getItemID(Files $file)
    {
        foreach($this->getTaggedFiles() as $id=>$item){
//            dd($item);
            if($item->files->id == $file->id) return $id+1;
        }
        return null;
    }

    public function getTaggedFileComments()
    {
        /** @var myModel $this */
        return $this->make('taggedFileComments',function(){
            $files = $this->getTaggedFiles();
            $ids = [];
            foreach($files as $f){
                $ids[]=$f->files->id;
            }
            if(count($ids) == 0) return [];
            $query = Comments::query()
                ->leftJoin('Users','Users.id = Comments.user_id')
                ->leftJoin('Taggables','commentable_type = "Taggables" AND commentable_id = Taggables.id')
                ->leftJoin('Files','Taggables.taggable_type = "Files" AND Taggables.taggable_id = Files.id')
                ->leftJoin('Tags','Taggables.tag_id = Tags.id')
                ->Where('Tags.id = :tag:',['tag'=>$this->id])
                ->inWhere('Files.id',$ids)
                ->orderBy('Comments.updated_at DESC')
                ->columns(['Files.*','Comments.*','Users.*']);
            return $query->execute();

//            $taggables = Taggables::query()
//                ->leftJoin('Tags','Tags.id = Taggables.tag_id')
//                ->where('Tags.id = :tag:',['tag'=>$this->id])
//                ->leftJoin('Taggables','T2.taggable_id = Taggables.taggable_id AND T2.taggable_type = Taggables.taggable_type','T2')
//                ->execute();
//            dd($taggables->toArray());

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

    public function softDeleteFiles(array $file_id)
    {
        if(count($file_id)){
            $taggables = Taggables::query()
                ->where('tag_id = :tag:',['tag'=>$this->id])
                ->inWhere('taggable_id',$file_id)
                ->andWhere('taggable_type = "Files"')
                ->execute();
            $taggables->delete();
            return true;
        }
        return false;
    }
    public function deleteByCurrentUser()
    {
        $user = \Phalcon\Di::getDefault()->get('auth');
        $taggables = Taggables::query()
            ->where('tag_id = :tag:',['tag'=>$this->id])
            ->andWhere('user_id = :user:',['user'=>$user->id])
            ->execute();
        $taggables->delete();
        $taggables = Taggables::query()
            ->where('tag_id = :tag:',['tag'=>$this->id])
            ->execute();

        $meta = $this->getTagmetaOrNew();
        $meta->delete();

        if($taggables->count() == 0) $this->delete();

    }


    /**这个函数将来在PHP7中能够更加简化
     * 针对不同的登录用户，显示当前登录用户的标签
     * @return mixed
     */
    public function getAllTags()
    {
        return $this->make('allTags',function(){
            $user = \Phalcon\Di::getDefault()->get('auth');
            return Tags::query()
                ->leftJoin('Taggables','Taggables.tag_id = Tags.id')
                ->where('Taggables.user_id = :user:',['user'=>$user->id])
                ->groupBy('Tags.id')
                ->orderBy('Tags.updated_at DESC')
                ->execute();
        });
    }

    public function getTagmetaOrNew()
    {
        $user = \Phalcon\Di::getDefault()->get('auth');
        $meta = Tagmetas::query()
            ->where('tag_id = :tag:',['tag'=>$this->id])
            ->andWhere('user_id = :user:',['user'=>$user->id])
            ->execute()->getFirst();
        if($meta) return $meta;
        return new Tagmetas([
            'tag_id'=>$this->id,
            'user_id'=>$user->id,
        ]);
    }
    public function beforeDeleteRemoveCacheTags()
    {
        $this->deleteCacheTags();
    }

    protected function deleteCacheTags()
    {
        $user = \Phalcon\Di::getDefault()->get('auth');
        /** @var Redis $redis */
        $redis = \Phalcon\Di::getDefault()->get('redis');
        $key = 'standard:user-'.$user->id.':tags';
        $redis->delete($key);
    }

}
