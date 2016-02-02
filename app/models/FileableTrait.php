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


    public function addWebFile($source_id,$type)
    {
        $parser = myParser::getParser($type,$source_id);//获取Parser
//        dd($parser);
        $data = $parser->parseInfo();//抽取数据
//        dd($data);
        /** @var myModel|FileableTrait $this */
        $this->save($parser->getDataForFile());//保存file对象

        $data['file_id'] = $this->id;//补充数据，添加file_id
        $model = myParser::getModelBySourceId($type);//获取模型
        $model->save($data);//保存模型数据

        EventFacade::fire('standards:addWebFile',$model);

        $this->saveFileable($model);//保存关联对象数据
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