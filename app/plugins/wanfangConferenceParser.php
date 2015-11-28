<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/28
 * Time: 11:49
 */
use Goutte\Client;
class wanfangConferenceParser extends WanfangWebParser
{
    protected $format = [
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
    protected $url = 'http://d.wanfangdata.com.cn/Conference/';
    protected $patchKeys = ['关键词'];

    protected function patchValue($key, $value, $row)
    {
        if($key == '关键词') {
            $links = [];
            $row->filter('.text a')->each(function($link) use (&$links){
                $links[] =$link->text();
            });
            $value = implode(' ',$links);
        }
        return $value;
    }
}