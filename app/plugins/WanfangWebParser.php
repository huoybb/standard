<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/28
 * Time: 17:20
 */
use Goutte\Client;
abstract class WanfangWebParser extends myParser
{
    protected $format = [];
    protected $patchKeys = [];
    protected $url = null;//需要被继承者替换掉的变量

    public function Id2Url($wanfangId = null)
    {
        if($wanfangId == null) $wanfangId = $this->source_id;
        if($this->url == null) dd('url是空的，请注意！');
        return $this->url.$wanfangId;
    }

    public function getDataForFile()
    {
        return
            [
                'title'=> $this->info['title'],
                'url'=>$this->Id2Url(),
                'updated_at_website'=>$this->info['publishDate']
            ];

    }


    public function parseInfo($wanfangId = null)
    {
        if($wanfangId == null) $wanfangId = $this->source_id;

        $crawler = $this->client->request('get',$this->Id2Url($wanfangId));
        $data = $this->getBaseInfo($crawler);

        $crawler->filter('.baseinfo-feild .row')->each(function($row) use(&$data) {
            /** @var Symfony\Component\DomCrawler\Crawler $row */
            if($row->filter('.pre')->count()){
                $key = preg_replace('/(\s*)|(：)/m', '', trim($row->filter('.pre')->text()));
                $value = trim($row->filter('.text')->text());
                if(in_array($key,$this->patchKeys)) $value = $this->patchValue($key,$value,$row);
                $data[$key]=$value;
            }

        });
        $result = ['wanfangId'=>$wanfangId];
        foreach($data as $key=>$value){
            if($this->format($key)) $result[$this->format($key)]=$value;
        }
        $this->info = $result;
        return $this->info;
    }
    protected function format($key)
    {
        if(isset($this->format[$key])) return $this->format[$key];
        return null;
    }
    protected function getBaseInfo($crawler)
    {
        $data = [];
        /** @var Symfony\Component\DomCrawler\Crawler $crawler */
        $data['title'] = $this->getTitle($crawler);
        //修正没有英文标题的问题
        $data['english_title'] = $this->getEngishTitle($crawler);
        $data['abstract'] = $this->getAbstract($crawler);
//        dd($data);
        return $data;
    }
    protected function getTitle($crawler)
    {
        /** @var Symfony\Component\DomCrawler\Crawler $crawler */
        return trim($crawler->filter('.section-baseinfo h1')->text());
    }
    protected function getEngishTitle($crawler)
    {
        /** @var Symfony\Component\DomCrawler\Crawler $crawler */
        if($crawler->filter('.section-baseinfo h2')->count() == 0) return null;
        return trim($crawler->filter('.section-baseinfo h2')->text());
    }

    protected function getAbstract($crawler)
    {
        /** @var Symfony\Component\DomCrawler\Crawler $crawler */
        if($crawler->filter('.abstract .fl .text')->count()){
            return  trim($crawler->filter('.abstract .fl .text')->text());
        }
        return trim($crawler->filter('.abstract .text')->text());
    }
    abstract protected function patchValue($key,$value,$row);


}