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
        if(property_exists($this,'relationCount')) return $this->relationCount > 0;
        return $this->getCitations()->count()+$this->getReferences()->count() > 0;
    }
    public function addReference(myModel $object){
        if($this->getRelationByObject($object)) return $this;

        $relation = new Relationship();
        $relation->save([
            'start_id'=>$object->id,
            'start_type'=>get_class($object),
            'end_id'=>$this->id,
            'end_type'=>get_class($this),
            'type'=>get_class($this)
        ]);
        if(property_exists($this,'relationCount')){
            $object->save(['relationCount'=>$object->relationCount+1]);
            $this->save(['relationCount'=>$this->relationCount+1]);
        }

        return $this;
    }
    public function deleteReference(myModel $object)
    {
        $relation = $this->getRelationByObject($object);
        if($relation) {
            $relation->delete();
            if(property_exists($this,'relationCount')){
                $object->save(['relationCount'=>$object->relationCount - 1]);
                $this->save(['relationCount'=>$this->relationCount - 1]);
            }

        }
        return $this;
    }
    public function getRelationByObject(myModel $object)//获取与当前object的参考关系对象
    {
        return Relationship::query()
            ->where('start_id = :start:',['start'=>$object->id])
            ->andWhere('start_type = :start_type:',['start_type'=>get_class($this)])
            ->andWhere('end_id = :end:',['end'=>$this->id])
            ->andWhere('end_type = :end_type:',['end_type'=>get_class($this)])
            ->execute()->getFirst();
    }

    public function addReferenceList(array $ids)
    {
        foreach($ids as $id){
            $object = self::findFirst($id);
            $this->addReference($object);
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
                ->leftJoin('Relationship','r2.start_id = '.$className.'.id AND r2.start_type = "'.$className.'"','r2')
                ->where('r2.end_id = :id:',['id'=>$this->id])
                ->andWhere('r2.end_type = :type:',['type'=>$className])
                ->execute();
        });
    }

    public function getSecondReferences()
    {
        return $this->make('ref2',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.start_id = '.$className.'.id AND r2.start_type = "'.$className.'"','r2')
                ->leftJoin('Relationship','r1.start_id = r2.end_id AND r1.start_type = r2.end_type','r1')
                ->where('r1.end_id = :end:',['end'=>$this->id])
                ->groupBy($className.'.id')
                ->execute();
        });

    }
    public function getCitations()
    {
        return $this->make('cite1',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.end_id = '.$className.'.id AND r2.end_type = "'.$className.'"','r2')
                ->where('r2.start_id = :id:',['id'=>$this->id])
                ->andWhere('r2.start_type = :type:',['type'=>$className])
                ->execute();
        });
    }
    public function getSecondCitations()
    {
        return $this->make('cite2',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.end_id = '.$className.'.id AND r2.end_type = "'.$className.'"','r2')
                ->leftJoin('Relationship','r1.end_id = r2.start_id AND r1.end_type = r2.start_type','r1')
                ->where('r1.start_id = :start:',['start'=>$this->id])
                ->groupBy($className.'.id')
                ->execute();
        });

    }

    public function getSameReferences()
    {
        return $this->make('sameRef',function(){
            $className = get_class($this);
            return self::query()
                ->leftJoin('Relationship','r2.end_id = '.$className.'.id AND r2.end_type = "'.$className.'"','r2')
                ->leftJoin('Relationship','r1.start_id = r2.start_id AND r1.start_type = r2.start_type','r1')
                ->where('r1.end_id = :end:',['end'=>$this->id])
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
                ->leftJoin('Relationship','r2.start_id = '.$className.'.id AND r2.start_type = "'.$className.'"','r2')
                ->leftJoin('Relationship','r1.end_id = r2.end_id AND r1.end_type = r2.end_type','r1')
                ->where('r1.start_id = :start:',['start'=>$this->id])
                ->andWhere($className.'.id != :id:',['id'=>$this->id])
                ->groupBy($className.'.id')
                ->execute();
        });
    }

    public function beforeDeleteRemoveRelationships()
    {
        foreach($this->getReferences() as $file){
            $this->deleteReference($file);
        }
        foreach($this->getCitations() as $file){
            $file->deleteReference($this);
        }
        return $this;
    }

}