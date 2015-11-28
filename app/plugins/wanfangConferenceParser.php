<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/28
 * Time: 11:49
 */
use Goutte\Client;
class wanfangConferenceParser
{
    private $wanfangId = null;
    private $format = [
        'title'=>'title',
        'abstract'=>'abstract',
        '作者'=>'Personal_Author',
        '作者单位'=>'Corporate_Author',
        '母体文献'=>'parent_literature',
        '会议名称'=>'conference_title',
        '会议时间'=>'conference_date',
        '会议地点'=>'conference_place',
        '主办单位'=>'host_unit',
        '在线出版日期'=>'publishDate',
        '关键词'=>'keywords',
    ];
    public function __construct($wanfangId = null)
    {
        if($wanfangId <> null) $this->wanfangId = $wanfangId;
        $this->client = new Client();
    }
    public function Id2Url($wanfangId = null)
    {
        if($wanfangId == null) $wanfangId = $this->wanfangId;
        return 'http://d.wanfangdata.com.cn/Conference/'.$wanfangId;
    }
    public function parseInfo($wanfangId = null){
        if($wanfangId == null) $wanfangId = $this->wanfangId;
        $data = [];
        $crawler = $this->client->request('get',$this->Id2Url($wanfangId));
        $data['title'] = trim($crawler->filter('.section-baseinfo h1')->text());
        if($crawler->filter('.abstract .fl .text')->count()){
            $data['abstract'] = trim($crawler->filter('.abstract .fl .text')->text());
        }else{
            $data['abstract'] = trim($crawler->filter('.abstract .row .text')->text());
        }


        $crawler->filter('.baseinfo-feild .row')->each(function($row) use(&$data) {
            /** @var Symfony\Component\DomCrawler\Crawler $row */
//            dd($row->filter('.pre')->count());
            if($row->filter('.pre')->count()){
                $key = preg_replace('/(\s*)|(：)/m', '', trim($row->filter('.pre')->text()));
                $value = trim($row->filter('.text')->text());
                if($key == '关键词') {
                    $links = [];
                    $row->filter('.text a')->each(function($link) use (&$links){
                        $links[] =$link->text();
                    });
                    $value = implode(' ',$links);
                }
                $data[$key]=$value;
            }
        });
        $result = ['wanfangId'=>$wanfangId];
        foreach($data as $key=>$value){
            if(isset($this->format[$key]))$result[$this->format[$key]]=$value;
        }
//        dd($result);
        return $result;
    }

}