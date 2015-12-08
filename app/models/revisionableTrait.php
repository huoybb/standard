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

    /**
     * @return Revisions
     */
    public function findOrCreateRevision()
    {
        /** @var myModel $this */
        return $this->make('revision',function(){
            /** @var myModel $this */
            $revision =  Revisions::findFirst(['file_id = :id:','bind'=>['id'=>$this->id]]);
            if($revision == null) $revision = new Revisions(['file_id'=>$this->id]);
            return $revision;
        });
    }


    public function beforeDeleteForRevision()
    {
        $revision = $this->getRevision();
        if($revision) $revision->delete();
        return $this;
    }
    public function addRevisionWithAnotherFile(Files $file)
    {
        $rev1 = $this->findOrCreateRevision();
        $rev2 = $file->findOrCreateRevision();
        if($rev1->id){//存在版本
            $rev2->save(['parent_id'=>$rev1->parent_id]);
            return true;
        }
        if($rev1->id == null AND $rev2->id <> null){
            $rev1->save(['parent_id'=>$rev2->parent_id]);
            return true;
        }
        if($rev1->id == null AND $rev2->id == null){
            $rev1->save();
            $rev1->save(['parent_id'=>$rev1->id]);
            $rev2->save(['parent_id'=>$rev1->id]);
            return true;
        }
        return false;
    }
    public static function combineRevisions(array $fileList)
    {
        if(count($fileList) == 0) return false;
        $first = Files::findFirst(array_shift($fileList));
        foreach($fileList as $id){
            $second = Files::findFirst($id);
            $first->addRevisionWithAnotherFile($second);
            $first = Files::findFirst($id);
        }
        return true;
    }


}