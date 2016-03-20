<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/26
 * Time: 18:12
 */
use Goutte\Client;
class wanfangParser extends WanfangWebParser
{
    protected $format = [
        'title'=>'title',
        'english_title'=>'english_title',
        'abstract'=>'abstract',
        'doi'=>'doi',
        '作者'=>'Personal_Author',
        '作者单位'=>'Corporate_Author',
        '刊名'=>'Journal',
        '年，卷(期)'=>'yearMonthNumber',
        '在线出版日期'=>'publishDate',
        '关键词'=>'keywords'

    ];
    protected $url = 'http://d.wanfangdata.com.cn/Periodical/';
    protected $patchKeys = ['刊名','作者','关键词'];

    protected function patchValue($key, $value, $row)
    {
        if($key == '刊名') $value = preg_replace('/(\S+)\s+\S+/m', '$1', $value);
        if($key == '作者') $value = preg_replace('/\s+/m', ' ', $value);
        if($key == '关键词') {
            $links = [];
            /** @var Symfony\Component\DomCrawler\Crawler $row */
            $row->filter('.text a')->each(function($link) use (&$links){
                /** @var Symfony\Component\DomCrawler\Crawler $link */
                $links[] =$link->text();
            });
            $value = implode(' ',$links);
        }
        return $value;
    }

}