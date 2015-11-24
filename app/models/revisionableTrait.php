<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/22
 * Time: 7:27
 */
trait revisionableTrait
{
    public function getRevision()
    {
        /** @var myModel $this */
        return $this->make('revision',function(){
            /** @var myModel $this */
            return Revisions::findFirst(['file_id = :id:','bind'=>['id'=>$this->id]]);
        });
    }

    public function beforeDeleteForRevision()
    {
        $revision = $this->getRevision();
        if($revision) $revision->delete();
        return $this;
    }

}