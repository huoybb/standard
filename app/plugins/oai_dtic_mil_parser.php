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
        $result['source_id']=$source_id;
        $result['title'] = $result['Title'];
        $this->info = $result;
        return $this->info;
    }


    public function getDataForFile()
    {
        $source_id = $this->source_id?:$this->info['source_id'];
        return [
            'title'=>$this->info['title'],
            'url'=>$this->Id2Url($source_id),
            'updated_at_website'=>$this->info['Report_Date'],
            'standard_number'=>$this->info['source_id'],
        ];
    }

    public function Id2Url($source_id = null)
    {
        return 'http://oai.dtic.mil/oai/oai?verb=getRecord&metadataPrefix=html&identifier='.$source_id;
    }
}