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
     * @return FileableInterface
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
                $objectName = $fileable->fileable_type;
                return $objectName::findFirst($fileable->fileable_id);
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
        $fileable_object = $this->getFileable();
        if($fileable_object) $fileable_object->delete();
        $fileable = Fileable::query()
            ->where('file_id = :id:',['id'=>$this->id])
            ->execute();
        if($fileable) $fileable->delete();
        return $this;
    }

    public function saveDoDFile($source_id)
    {
        $type = 'DoDFile';
        return $this->addWebFile($source_id,$type);
    }


    public function saveWanfangFile($source_id, $type = 'Periodical')
    {
        return $this->addWebFile($source_id,$type);
    }

    public function saveEverySpecFile($source_id)
    {
        $type = 'EverySpec';
        return $this->addWebFile($source_id,$type);
    }

    private function addWebFile($source_id,$type)
    {
        $parser = myParser::getParser($type,$source_id);
        $data = $parser->parseInfo();
        $this->save($parser->getDataForFile());
        $data['file_id'] = $this->id;
        $model = myParser::getModel($type);
        $model->save($data);
        $this->saveFileable($model);
        return $this;
    }
    private function saveFileable($fileableObject)
    {
        return (new Fileable())->save([
            'file_id'=>$this->id,
            'fileable_type'=>get_class($fileableObject),
            'fileable_id'=>$fileableObject->id,
        ]);
    }


}