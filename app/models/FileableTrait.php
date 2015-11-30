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
        $DoD_file = new oai_dtic_mil_parser();
        $info = $DoD_file->parseInfo($source_id);

        /** @var Files $this */
        $this->save([
            'title'=> $info['Title'],
            'url'=>$DoD_file->getURLById($source_id),
            'updated_at_website'=>$info['Report_Date'],
            'standard_number'=>$info['Accession_Number']
        ]);

        $info['file_id'] = $this->id;

        $oaiDticMil = new OaiDticMil();
        $oaiDticMil->save($info);

        $this->saveFileable($oaiDticMil);
        return $this;
    }


    public function saveWanfangFile($source_id, $type = 'Periodical')
    {
        $wf = WanfangWebParser::getParser($type,$source_id);
        $data = $wf->parseInfo();
        $this->save([
            'title'=> $data['title'],
            'url'=>$wf->Id2Url(),
            'updated_at_website'=>$data['publishDate']
        ]);
        $data['file_id']=$this->id;
        $wanfang = WanfangWebParser::getModel($type);
        $wanfang->save($data);
        $this->saveFileable($wanfang);

        return $this;
    }

    public function saveEverySpecFile($source_id)
    {
        $es = new everySpecParser($source_id);
        $data = $es->parseInfo();
        $this->save([
            'title'=>$data['standard_no'].','.$data['title'],
            'url'=>$es->getUrlFromId($source_id),
            'updated_at_website'=>$data['date']
        ]);
        $data['file_id']=$this->id;
        $everySpec = new Everyspec();
        $everySpec->save($data);
        $this->saveFileable($everySpec);
        return $this;
    }

    private function saveFileable($fileableObject)
    {
        (new Fileable())->save([
            'file_id'=>$this->id,
            'fileable_type'=>get_class($fileableObject),
            'fileable_id'=>$fileableObject->id,
        ]);
    }


}