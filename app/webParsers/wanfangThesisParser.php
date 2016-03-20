<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/27
 * Time: 14:44
 */
use Goutte\Client;
class wanfangThesisParser extends WanfangWebParser
{
    protected $format = [
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
    protected $url = 'http://d.wanfangdata.com.cn/Thesis/';
    protected $patchKeys = ['关键词','导师姓名'];

    protected function patchValue($key, $value, $row)
    {
        if($key == '关键词' OR $key =='导师姓名') {
            $links = [];
            $row->filter('.text a')->each(function($link) use (&$links){
                $links[] =$link->text();
            });
            $value = implode(' ',$links);
        }
        return $value;
    }
}