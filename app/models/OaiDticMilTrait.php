<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/24
 * Time: 10:56
 */
trait OaiDticMilTrait
{
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
        return $this;
    }

    /**
     * @return OaiDticMil
     */
    public function getOaiDticMil()
    {
        /** @var Files $this */
        return $this->make('OaiDticMil',function(){
            /** @var Files $this */
            return  OaiDticMil::query()
                ->where('file_id = :file:',['file'=>$this->id])
                ->execute()->getFirst();
        });
    }

    public function beforeDeleteForOaiDticMil()
    {
        /** @var Files $this */
        $dod = $this->getOaiDticMil();
        if($dod) $dod->delete();
        return $this;
    }



}