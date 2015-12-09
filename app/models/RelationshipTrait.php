<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/9
 * Time: 15:56
 */
trait RelationshipTrait
{
    public function addReference(myModel $file){
        $relation = Relationship::query()
            ->where('start_point = :start:',['start'=>$file->id])
            ->andWhere('end_point = :end:',['end'=>$this->id])
            ->execute()->getFirst();
        if($relation) return $this;
        $relation = new Relationship();
        $relation->save([
            'start_point'=>$file->id,
            'end_point'=>$this->id,
            'type'=>'reference'
        ]);
        return $this;
    }
    public function addReferenceList(array $ids)
    {
        foreach($ids as $id){
            $file = Files::findFirst($id);
            $this->addReference($file);
        }
        return $this;
    }

    public function getReferences()
    {
        return Files::query()
            ->leftJoin('Relationship','r2.start_point = Files.id','r2')
            ->where('r2.end_point = :end:',['end'=>$this->id])
            ->execute();
    }
    public function getSecondReferences()
    {
        return Files::query()
            ->leftJoin('Relationship','r2.start_point = Files.id','r2')
            ->leftJoin('Relationship','r1.start_point = r2.end_point','r1')
            ->where('r1.end_point = :end:',['end'=>$this->id])
            ->execute();

    }

    public function getCitations()
    {
        return Files::query()
            ->leftJoin('Relationship','r2.end_point = Files.id','r2')
            ->where('r2.start_point = :start:',['start'=>$this->id])
            ->execute();
    }
    public function getSecondCitations()
    {
        return Files::query()
            ->leftJoin('Relationship','r2.end_point = Files.id','r2')
            ->leftJoin('Relationship','r1.end_point = r2.start_point','r1')
            ->where('r1.start_point = :start:',['start'=>$this->id])
            ->execute();

    }



}