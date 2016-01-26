<?php

class Tags extends myModel
{

    use commentableTrait;
    use attachableTrait;
    use countForRootClassTrait;
    use RelationshipTrait;
    use StatisticsTrait;
    use timeableTrait;
    use LinkableTrait;
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
    /**
     *
     * @var integer
     */
    public $linkCount;
    /**
     *
     * @var integer
     */
    public $relationCount;

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
            'linkCount' => 'linkCount',
            'relationCount' => 'relationCount',
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

    public function getTaggedFiles(Users $user = null)
    {
        return $this->make('files',function() use($user){
            if($user == null) $user  = \Phalcon\Di::getDefault()->get('auth');
            return Files::query()
                ->rightJoin('Taggables','Taggables.taggable_id = Files.id AND Taggables.taggable_type="Files"')
                ->where('Taggables.tag_id = :tag:',['tag'=>$this->id])
                ->andWhere('Taggables.user_id = :user:',['user'=>$user->id])
                ->columns(['Files.*','Taggables.*'])
                ->groupBy('Files.id')
                ->orderBy('Taggables.updated_at DESC')//按照生成的时间排序，如果按照更新的时间排序，则会出现不稳定的现象，这个问题在多人一同操作的时候可能会发生，需要避免的
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
    public function getFileID($ItemID)
    {
        return $this->getTaggedFiles()[$ItemID-1];
    }


    public function getTaggedFileComments()
    {
        /** @var myModel $this */
        return $this->make('taggedFileComments',function(){
            $user = \Phalcon\Di::getDefault()->get('auth');
            $comments = Comments::query()
                ->leftJoin('Taggables','Comments.commentable_type = "Taggables" AND Comments.commentable_id = t1.id','t1')
                ->where('t1.tag_id = :tag:',['tag'=>$this->id])
                ->leftJoin('Taggables','t1.taggable_type = t2.taggable_type AND t1.taggable_id = t2.taggable_id','t2')
                ->andWhere('t2.user_id = :user:',['user'=>$user->id])
                ->groupBy('Comments.id')
                ->orderBy('Comments.updated_at DESC')
                ->leftJoin('Files','t1.taggable_type = "Files" AND t1.taggable_id = Files.id')
                ->leftJoin('Users','Users.id = Comments.user_id')
                ->columns(['Files.*','Comments.*','Users.*'])
                ->execute();
            return $comments;
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
        $event = \Phalcon\Di::getDefault()->get('Event');
        $event->fire('tags:updateTag',$this);
    }

//    protected function deleteCacheTags()
//    {
//        /** @var myRedis $redis */
//        $redis = \Phalcon\Di::getDefault()->get('redis');
//        $redis->deleteTags();
//    }


    public function getUsersLikeThisTag()
    {
        return Users::query()
            ->leftJoin('Tagmetas','meta.user_id = Users.id','meta')
            ->where('meta.tag_id = :tag:',['tag'=>$this->id])
            ->execute();
    }

    public function getShowItemPage($file)
    {
        $paginator = new Phalcon\Paginator\Adapter\Model([
            'data'=> $this->getTaggedFiles(),
            'limit'=> 1,
            'page'=> $this->getItemID($file)
        ]);
        $page = $paginator->getPaginate();
        //修正循环的问题
        if($page->next == $page->current) $page->next = 1;
        if($page->before == $page->current) $page->before = $page->last;

        $page->next = $this->getTaggedFiles()[$page->next - 1]->files->id;
        $page->before = $this->getTaggedFiles()[$page->before - 1]->files->id;

        return $page;
    }

    public function beforeSave()
    {
        eventFacade::fire('tags:updateTag',$this);
        return parent::beforeSave();
    }



}
