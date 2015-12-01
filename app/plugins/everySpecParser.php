<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/30
 * Time: 20:56
 */
class everySpecParser extends myParser
{

    public function parseInfo($source_id = null)
    {
        $crawler = $this->client->request('get',$this->Id2Url());

        $result = ['source_id'=>$this->source_id];

        $data = $crawler->filter('h1')->text();
        if (preg_match('/^((?<no>[^,]+),)?\s*(?<title>[^(]+)\((?<date>[^)]+)\)?.*$/m', $data, $regs)) {
            if(isset($regs['no']))$result['standard_no'] = $regs['no'];
            $result['title'] = $regs['title'];
            $result['date'] = $regs['date'];
        }

        $result['abstract'] = $crawler->filter('h1')->nextAll()->last()->text();
        $this->info = $result;
        return $result;
    }
    public function Id2Url($file_id = null)
    {
        return base64_decode($this->source_id);
    }

    public function getDataForFile()
    {
        return [
            'title'=>$this->info['standard_no'].','.$this->info['title'],
            'url'=>$this->Id2Url($this->source_id),
            'updated_at_website'=>$this->info['date']
        ];
    }


}