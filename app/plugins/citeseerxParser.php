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
        $result['abstract'] =  $crawler->filter('#abstract p')->text();

        $data = $crawler->filter('#docVenue');
        if($data->count()) {
            if (preg_match('/Venue:(.+)/m', $data->text(), $regs)) {
                $result['venue'] = $regs[1];
            }
        }

        $data = $crawler->filter('#docCites');
        if($data->count()){
            if (preg_match('/Citations:(.+)/m', $data->text(), $regs)) {
                $result['citations'] = $regs[1];
            }
        }

        $this->info = $result;
        return $this->info;
    }

    public function getDataForFile()
    {
        $source_id = $this->source_id ?: $this->info['source_id'];
        $result = [
            'title'=>$this->info['title'],
            'url'=>$this->Id2Url($source_id),
            'standard_number'=>$source_id,
        ];
//        dd($result);
        return $result;
    }

    public function Id2Url($source_id = null)
    {
        $source_id = $source_id ?: $this->source_id;
        return 'http://citeseerx.ist.psu.edu/viewdoc/summary?doi='.$source_id;
    }
}