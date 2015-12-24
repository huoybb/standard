<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/22
 * Time: 7:21
 */
trait taggableTrait
{
    public function tags()
    {
        /** @var myModel $this */
        return $this->make('tags',function(){
            /** @var myModel $this */
            return Taggables::query()
                ->leftJoin('Tags','Tags.id = Taggables.tag_id')
                ->where('Taggables.taggable_type = :type:',['type'=>get_class($this)])
                ->andWhere('Taggables.taggable_id = :id:',['id'=>$this->id])
                ->columns(['Tags.id','Tags.name','Taggables.updated_at','Taggables.id AS tid'])
                ->execute();
        });
    }
    public function addTag(Tags $tag)
    {
        $taggables = $this->getTaggable($tag);
        if($taggables == null){
            $user = \Phalcon\Di::getDefault()->get('auth');
            $data = [
                'tag_id'=>$tag->id,
                'taggable_type'=>get_class($this),
                'taggable_id'=>$this->id,
                'user_id'=>$user->id
            ];
            $taggable = new Taggables();
            $taggable->save($data);
            $tag->increaseCount('taggableCount');
        }
        return $this;
    }
    public function deleteTag(Taggables $taggable){
        $tag = $taggable->tag();
        $taggable->delete();
        $tag->decreaseCount('taggableCount');
        return $this;
    }
    public function beforeDeleteForTaggables()
    {
        $taggables = Taggables::query()
            ->where('Taggables.taggable_type = :type:',['type'=>get_class($this)])
            ->andWhere('Taggables.taggable_id = :id:',['id'=>$this->id])
            ->execute();
        foreach($taggables as $taggable){
            $this->deleteTag($taggable);
        }
        return $this;
    }

    /**
     * @param Tags $tag
     * @return myModel
     */
    public function getTaggable(Tags $tag){
        return Taggables::query()
            ->where('tag_id = :tag:',['tag'=>$tag->id])
            ->andWhere('taggable_type = :type:',['type'=>get_class($this)])
            ->andWhere('taggable_id = :id:',['id'=>$this->id])
            ->execute()->getFirst();
    }
    public function getTaggableComments(Tags $tag=null)
    {
        /** @var myModel $this */
        return $this->make('taggableComments',function() use($tag){
            $query = Comments::query()
                ->leftJoin('Users','Comments.user_id = Users.id')
                ->leftJoin('Taggables','commentable_type = "Taggables" AND commentable_id = Taggables.id')
                ->leftJoin('Files','Taggables.taggable_type = "Files" AND Taggables.taggable_id = Files.id')
                ->leftJoin('Tags','Taggables.tag_id = Tags.id')
                ->where('Files.id = :id:',['id'=>$this->id])
                ->orderBy('Comments.updated_at DESC')
                ->columns(['Tags.*','Comments.*','Users.*']);
            if($tag <> null) $query=$query->andWhere('Tags.id = :tag:',['tag'=>$tag->id]);
            return $query->execute();
        });
    }



}