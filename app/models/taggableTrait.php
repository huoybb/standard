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
            return Taggables::query()
                ->leftJoin('Tags','Tags.id = Taggables.tag_id')
                ->where('Taggables.taggable_type = :type:',['type'=>get_class($this)])
                ->andWhere('Taggables.taggable_id = :id:',['id'=>$this->id])
                ->columns(['Tags.id','Tags.name','Taggables.updated_at','Taggables.id AS tid'])
                ->execute();
        });
    }
}