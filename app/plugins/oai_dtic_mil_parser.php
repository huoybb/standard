<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/22
 * Time: 14:27
 */
class oai_dtic_mil_parser extends myParser
{

    public function parseInfo($source_id =null)
    {
        if(null == $source_id) $source_id = $this->source_id;
        $result = [];
        $crawler = $this->client->request('get',$this->Id2Url($source_id));
        $crawler->filter('p')->each(function($info) use(&$result){
            /** @var Symfony\Component\DomCrawler\Crawler $info */
            if (preg_match('%<b>\s*([^:]+?)\s*:.*?</b>(.+)$%sm', $info->html(), $regs)) {
                $name = $regs[1];
                $name = str_replace(' ','_',$name);
                $name = str_replace('(s)','',$name);

                $value = $regs[2];
                $result[$name] = $value;
            }
        });
        $this->info = $result;
        return $this->info;
    }


    public function getDataForFile()
    {
        return [
            'title'=> $this->info['Accession_Number'].'-'.$this->info['Title'],
            'url'=>$this->Id2Url($this->source_id),
            'updated_at_website'=>$this->info['Report_Date'],
            'standard_number'=>$this->info['Accession_Number']
        ];
    }

    public function Id2Url($source_id = null)
    {
        return 'http://oai.dtic.mil/oai/oai?verb=getRecord&metadataPrefix=html&identifier='.$source_id;
    }
}