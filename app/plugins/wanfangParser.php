<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/26
 * Time: 18:12
 */
use Goutte\Client;
class wanfangParser
{
    private $wanfangId = null;
    private $format = [
        'title'=>'title',
        'english_title'=>'english_title',
        '摘要'=>'abstract',
        'doi'=>'doi',
        '作者'=>'Personal_Author',
        '作者单位'=>'Corporate_Author',
        '刊名'=>'Journal',
        '年，卷(期)'=>'yearMonthNumber',
        '在线出版日期'=>'publishDate',
        '关键词'=>'keywords'

    ];
    public function __construct($wanfangId = null)
    {
        if($wanfangId <> null) $this->wanfangId = $wanfangId;
        $this->client = new Client();
    }

    public function Id2Url($wanfangId = null)
    {
        if($wanfangId == null) $wanfangId = $this->wanfangId;
        return 'http://d.wanfangdata.com.cn/Periodical/'.$wanfangId;
    }

    public function parseInfo($wanfangId = null)
    {
        if($wanfangId == null) $wanfangId = $this->wanfangId;
        $data = [];
        $crawler = $this->client->request('get',$this->Id2Url($wanfangId));
        $data['title'] = trim($crawler->filter('.section-baseinfo h1')->text());
        //修正没有英文标题的问题
        if($crawler->filter('.section-baseinfo h2')->count()){
            $data['english_title'] = trim($crawler->filter('.section-baseinfo h2')->text());
        }
//        $data['abstract'] = trim($crawler->filter('.abstract .text')->text());
//        dd($data);
        $crawler->filter('.baseinfo-feild .row')->each(function($row) use(&$data) {
            /** @var Symfony\Component\DomCrawler\Crawler $row */
            $key = preg_replace('/(\s*)|(：)/m', '', trim($row->filter('.pre')->text()));
            $value = trim($row->filter('.text')->text());
            if($key == '刊名') $value = preg_replace('/(\S+)\s+\S+/m', '$1', $value);
            if($key == '作者') $value = preg_replace('/\s+/m', ' ', $value);
            if($key == '关键词') {
                $links = [];
                $row->filter('.text a')->each(function($link) use (&$links){
                    $links[] =$link->text();
                });
                $value = implode(' ',$links);
            }
            $data[$key]=$value;
        });
        $result = ['wanfangId'=>$wanfangId];
        foreach($data as $key=>$value){
            if(isset($this->format[$key]))$result[$this->format[$key]]=$value;
        }
        return $result;
    }



}