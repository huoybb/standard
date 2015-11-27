<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/27
 * Time: 10:07
 */
trait FileableTrait
{
    public function getFileable()
    {
        /** @var Files $this */
        return $this->make('fileable',function(){
            /** @var Files $this */
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

    public function saveDoDFile($file_id)
    {
        $DoD_file = new oai_dtic_mil_parser();
        $info = $DoD_file->parseInfo($file_id);

        /** @var Files $this */
        $this->save([
            'title'=> $info['Title'],
            'url'=>$DoD_file->getURLById($file_id),
            'updated_at_website'=>$info['Report_Date'],
            'standard_number'=>$info['Accession_Number']
        ]);

        $info['file_id'] = $this->id;

        $oaiDticMil = new OaiDticMil();
        $oaiDticMil->save($info);
        (new Fileable())->save([
            'file_id'=>$this->id,
            'fileable_type'=>get_class($oaiDticMil),
            'fileable_id'=>$oaiDticMil->id,
        ]);
        return $this;
    }

    public function saveWanfangFile($wanfangId)
    {
        $wf = new wanfangParser($wanfangId);
        $data = $wf->parseInfo();
        /** @var Files $this */
        $this->save([
            'title'=> $data['title'],
            'url'=>$wf->Id2Url(),
            'updated_at_website'=>$data['publishDate']
        ]);
        $data['file_id']=$this->id;
        $data['wanfangId']=$wanfangId;

        $wanfang = new Wanfang();
        $wanfang->save($data);

        (new Fileable())->save([
            'file_id'=>$this->id,
            'fileable_type'=>get_class($wanfang),
            'fileable_id'=>$wanfang->id,
        ]);
        return $this;
    }


}