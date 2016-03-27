<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/27
 * Time: 10:07
 */
trait FileableTrait
{
    /**
     * @return FileableInterface | \Phalcon\Mvc\Model |null
     */
    public function getFileable()
    {
        /** @var Files $this */
        return $this->make('fileable',function(){
            /** @var Files $this */
            /** @var Fileable $fileable */
            $fileable =  Fileable::query()
                ->where('file_id = :id:',['id'=>$this->id])
                ->execute()->getFirst();
            if($fileable){
                return myParser::getModel($fileable->fileable_type,$fileable->fileable_id);
            }
            return null;
        });
    }

    public function getFileType()
    {
        $type = '标准';
        if($this->getFileable()){
            $type = $this->getFileable()->getType();
        }
        return $type;
    }

    public function beforeDeleteRemoveFilealbe()
    {
        //删除链接对应的库中的数据
        $fileable_object = $this->getFileable();
        if($fileable_object) $fileable_object->delete();
        //删除链接表中的数据
        $fileable = Fileable::query()
            ->where('file_id = :id:',['id'=>$this->id])
            ->execute();
        if($fileable) $fileable->delete();
        return $this;
    }

    public function saveFileable($fileableObject)
    {
        return (new Fileable())->save([
            'file_id'=>$this->id,
            'fileable_type'=>get_class($fileableObject),
            'fileable_id'=>$fileableObject->id,
        ]);
    }



}