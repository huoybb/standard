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
        if($taggables->count() == 0){
            $data = [
                'tag_id'=>$tag->id,
                'taggable_type'=>get_class($this),
                'taggable_id'=>$this->id,
                'user_id'=>1//@todo 改成auth的变量
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

    public function getTaggable(Tags $tag){
        return Taggables::query()
            ->where('tag_id = :tag:',['tag'=>$tag->id])
            ->andWhere('taggable_type = :type:',['type'=>get_class($this)])
            ->andWhere('taggable_id = :id:',['id'=>$this->id])
            ->execute();
    }


}