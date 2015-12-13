<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/9
 * Time: 15:56
 */
trait RelationshipTrait
{
    public function hasRelations()
    {
        return $this->relationCount > 0;
    }
    public function addReference(myModel $file){
        if($this->getRelationByObject($file)) return $this;

        $relation = new Relationship();
        $relation->save([
            'start_point'=>$file->id,
            'end_point'=>$this->id,
            'type'=>get_class($this)
        ]);

        $file->save(['relationCount'=>$file->relationCount+1]);
        $this->save(['relationCount'=>$this->relationCount+1]);

        return $this;
    }
    public function deleteReference(myModel $file)
    {
        $relation = $this->getRelationByObject($file);
        if($relation) {
            $relation->delete();
            $file->save(['relationCount'=>$file->relationCount - 1]);
            $this->save(['relationCount'=>$this->relationCount - 1]);
        }
        return $this;
    }
    public function getRelationByObject(myModel $file)//获取与当前object的参考关系对象
    {
        return Relationship::query()
            ->where('start_point = :start:',['start'=>$file->id])
            ->andWhere('end_point = :end:',['end'=>$this->id])
            ->execute()->getFirst();
    }

    public function addReferenceList(array $ids)
    {
        foreach($ids as $id){
            $file = self::findFirst($id);
            $this->addReference($file);
        }
        return $this;
    }

    public function getRelation($type)
    {
        $format = [
            'ref1'=>'getReferences',
            'ref2'=>'getSecondReferences',
            'sameRef'=>'getSameReferences',
            'cite1'=>'getCitations',
            'cite2'=>'getSecondCitations',
            'sameCite'=>'getSameCitations',
        ];
        if(isset($format[$type])){
            $action = $format[$type];
            return $this->$action();
        }
        return [];
    }

    public function getRelationDescription($type)
    {
        $format = [
            'ref1'=>['title'=>'参考文献','note'=>'反映本文研究工作的背景和依据'],
            'ref2'=>['title'=>'二级参考文献','note'=>'本文参考文献的参考文献。进一步反映本文研究工作的背景和依据'],
            'sameRef'=>['title'=>'共参文献','note'=>'（也称同引文献）与本文有相同参考文献的文献，与本文有共同研究背景或依据'],
            'cite1'=>['title'=>'引证文献','note'=>'引用本文的文献。本文研究工作的继续、应用、发展或评价'],
            'cite2'=>['title'=>'二级引证文献','note'=>'本文引证文献的引证文献。更进一步反映本文研究工作的继续、发展或评价'],
            'sameCite'=>['title'=>'共引文献 ','note'=>'（与本文同时被作为参考文献引用的文献，与本文共同作为进一步研究的基础'],
        ];
        if(isset($format[$type])){
            return $format[$type];
        }
        return [];
    }



    public function getReferences()
    {
        return $this->make('ref1',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.start_point = '.$className.'.id','r2')
                ->where('r2.end_point = :end:',['end'=>$this->id])
                ->execute();
        });
    }

    public function getSecondReferences()
    {
        return $this->make('ref2',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.start_point = '.$className.'.id','r2')
                ->leftJoin('Relationship','r1.start_point = r2.end_point','r1')
                ->where('r1.end_point = :end:',['end'=>$this->id])
                ->groupBy($className.'.id')
                ->execute();
        });

    }
    public function getCitations()
    {
        return $this->make('cite1',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.end_point = '.$className.'.id','r2')
                ->where('r2.start_point = :start:',['start'=>$this->id])
                ->execute();
        });
    }
    public function getSecondCitations()
    {
        return $this->make('cite2',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.end_point = '.$className.'.id','r2')
                ->leftJoin('Relationship','r1.end_point = r2.start_point','r1')
                ->where('r1.start_point = :start:',['start'=>$this->id])
                ->groupBy($className.'.id')
                ->execute();
        });

    }

    public function getSameReferences()
    {
        return $this->make('sameRef',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.end_point = '.$className.'.id','r2')
                ->leftJoin('Relationship','r1.start_point = r2.start_point','r1')
                ->where('r1.end_point = :end:',['end'=>$this->id])
                ->andWhere($className.'.id != :id:',['id'=>$this->id])
                ->groupBy($className.'.id')
                ->execute();
        });
    }
    public function getSameCitations()
    {
        return $this->make('sameCite',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.start_point = '.$className.'.id','r2')
                ->leftJoin('Relationship','r1.end_point = r2.end_point','r1')
                ->where('r1.start_point = :start:',['start'=>$this->id])
                ->andWhere($className.'.id != :id:',['id'=>$this->id])
                ->groupBy($className.'.id')
                ->execute();
        });
    }
}