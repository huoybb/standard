<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/27
 * Time: 14:44
 */
use Goutte\Client;
class wanfangThesisParser
{
    private $wanfangId = null;
    private $format = [
        'title'=>'title',
        'abstract'=>'abstract',
        'doi'=>'doi',
        '作者'=>'Personal_Author',
        '学科专业'=>'major',
        '授予学位'=>'degree',
        '学位授予单位'=>'school',
        '导师姓名'=>'supervisor',
        '学位年度'=>'year',
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
        return 'http://d.wanfangdata.com.cn/Thesis/'.$wanfangId;
    }
    public function parseInfo($wanfangId = null){
        if($wanfangId == null) $wanfangId = $this->wanfangId;
        $data = [];
        $crawler = $this->client->request('get',$this->Id2Url($wanfangId));
        $data['title'] = trim($crawler->filter('.section-baseinfo h1')->text());
        $data['abstract'] = trim($crawler->filter('.abstract .fl .text')->text());

        $crawler->filter('.baseinfo-feild .row')->each(function($row) use(&$data) {
            /** @var Symfony\Component\DomCrawler\Crawler $row */
//            dd($row->filter('.pre')->count());
            if($row->filter('.pre')->count()){
                $key = preg_replace('/(\s*)|(：)/m', '', trim($row->filter('.pre')->text()));
                $value = trim($row->filter('.text')->text());
                if($key == '关键词' OR $key =='导师姓名') {
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