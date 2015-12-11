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

    public function getRelation($relation)
    {
        $format = [
            'ref1'=>'getReferences',
            'ref2'=>'getSecondReferences',
            'sameRef'=>'getSameReferences',
            'cite1'=>'getCitations',
            'cite2'=>'getSecondCitations',
            'sameCite'=>'getSameCitations',
        ];
        if(isset($format[$relation])){
            $action = $format[$relation];
            return $this->$action();
        }
        return [];
    }

    public function getRelationDescription($relation)
    {
        $format = [
            'ref1'=>['title'=>'参考文献','note'=>'参考了哪些文献，或者引用了哪些标准'],
            'ref2'=>['title'=>'二级参考文献','note'=>'***'],
            'sameRef'=>['title'=>'共参文献','note'=>'***'],
            'cite1'=>['title'=>'引证文献','note'=>'****'],
            'cite2'=>['title'=>'二级引证文献','note'=>'****'],
            'sameCite'=>['title'=>'共引文献','note'=>'（也称同引文献）与本文有相同参考文献的文献，与本文有共同研究背景或依据'],
        ];
        if(isset($format[$relation])){
            return $format[$relation];
        }
        return [];
    }



    public function getReferences()
    {
        return $this->make('ref1',function(){
            return Files::query()
                ->leftJoin('Relationship','r2.start_point = Files.id','r2')
                ->where('r2.end_point = :end:',['end'=>$this->id])
                ->execute();
        });
    }

    public function getSecondReferences()
    {
        return $this->make('ref2',function(){
            return Files::query()
                ->leftJoin('Relationship','r2.start_point = Files.id','r2')
                ->leftJoin('Relationship','r1.start_point = r2.end_point','r1')
                ->where('r1.end_point = :end:',['end'=>$this->id])
                ->groupBy('Files.id')
                ->execute();
        });

    }
    public function getCitations()
    {
        return $this->make('cite1',function(){
            return Files::query()
                ->leftJoin('Relationship','r2.end_point = Files.id','r2')
                ->where('r2.start_point = :start:',['start'=>$this->id])
                ->execute();
        });
    }
    public function getSecondCitations()
    {
        return $this->make('cite2',function(){
            return Files::query()
                ->leftJoin('Relationship','r2.end_point = Files.id','r2')
                ->leftJoin('Relationship','r1.end_point = r2.start_point','r1')
                ->where('r1.start_point = :start:',['start'=>$this->id])
                ->groupBy('Files.id')
                ->execute();
        });

    }

    public function getSameReferences()
    {
        return $this->make('sameRef',function(){
            return Files::query()
                ->leftJoin('Relationship','r2.end_point = Files.id','r2')
                ->leftJoin('Relationship','r1.start_point = r2.start_point','r1')
                ->where('r1.end_point = :end:',['end'=>$this->id])
                ->andWhere('Files.id != :id:',['id'=>$this->id])
                ->groupBy('Files.id')
                ->execute();
        });
    }
    public function getSameCitations()
    {
        return $this->make('sameCite',function(){
            return Files::query()
                ->leftJoin('Relationship','r2.start_point = Files.id','r2')
                ->leftJoin('Relationship','r1.end_point = r2.end_point','r1')
                ->where('r1.start_point = :start:',['start'=>$this->id])
                ->andWhere('Files.id != :id:',['id'=>$this->id])
                ->groupBy('Files.id')
                ->execute();
        });
    }
}