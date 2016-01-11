<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/11
 * Time: 12:04
 */
class baiduxueshuParser extends myParser
{
    private $format = [
        'source_id'=>'source_id',
        'title'=>'title',
        '作者'=>'writer',
        '摘要'=>'abstract',
        '出版源'=>'publisher',
        '关键词'=>'keywords',
        '被引量'=> 'cited',
    ];
    public function parseInfo($source_id = null)
    {
        $crawler = $this->client->request('get',$this->Id2Url());
        $result = ['source_id'=>$this->source_id];
        $result['title'] = $crawler->filter('h3')->first()->text();

        $crawler->filter('div.c_content div')->each(function($row)use(&$result){
            /** @var Symfony\Component\DomCrawler\Crawler $row */
            $key = $row->filter('.label')->text();
            $value = $row->filter('.label')->nextAll()->first()->text();
            if(isset($this->format[$key])) $result[$this->format[$key]]=$value;
        });
        $this->info = $result;
        return $result;
    }
    public function Id2Url($file_id = null)
    {
        return base64_decode($this->source_id);
    }

    public function getDataForFile()
    {
        $result = [
            'title'=>$this->info['title'],
            'url'=>$this->Id2Url($this->source_id),
        ];
        if($this->info['出版源']) $result['updated_at_website'] = explode(',',$this->info['出版源'])[1];
        return $result;
    }
}