<?php
namespace webParser;
use myParser;
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
    public function Id2Url($source_id = null)
    {
        $source_id = $source_id ?:$this->source_id;
        return base64_decode($source_id);
    }

    public function getDataForFile()
    {

        $result = parent::getDataForFile();
        $source_id = $this->source_id?:$this->info['source_id'];
        $result = array_merge(
            $result,
            [
                'title'=>$this->info['standard_no'].','.$this->info['title'],
                'updated_at_website'=>$this->info['date'],
            ]);
        if($this->info['standard_no']) $result['standard_number'] = $this->info['standard_no'];
        return $result;
    }


}