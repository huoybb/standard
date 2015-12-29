<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/28
 * Time: 23:22
 */
class citeseerxParser extends myParser
{

    public function parseInfo($source_id = null)
    {

        $crawler = $this->client->request('get',$this->Id2Url());

        $result = ['source_id'=>$this->source_id];
        $result['title'] = $crawler->filter('h2')->text();
        $data = $crawler->filter('#docAuthors')->text();
        if (preg_match('/\s+by\s+(\S.+\S)\s+/m', $data, $regs)) {
            $result['authors'] = $regs[1];
        }
        $result['abstract'] = $data = $crawler->filter('#abstract p')->text();
        $this->info = $result;
        return $this->info;
    }

    public function getDataForFile()
    {
        $result = [
            'title'=>$this->info['title'],
            'url'=>$this->Id2Url($this->source_id),
            'standard_number'=>$this->source_id,
        ];
//        dd($result);
        return $result;
    }

    public function Id2Url($source_id = null)
    {
        if($source_id == null) $source_id = $this->source_id;
        return 'http://citeseerx.ist.psu.edu/viewdoc/summary?doi='.$source_id;
    }
}