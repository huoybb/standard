<?php

/**
 * 这个对象将常见的一些工具集成在这个对象中
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/8/29
 * Time: 14:18
 */
class myTools
{
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    function formatTimeUnit($time){
        if($time >86400){
            $time = number_format($time / 86400,2).' 天';
        }elseif ($time > 3600){
            $time = number_format($time / 3600,2).' 小时';
        }elseif ($time > 60){
            $time = number_format($time / 60,2).' 分钟';
        }elseif ($time > 0){
            $time=$time.' 秒';
        }else {
            $time = '0秒';
        }
        return $time;
    }
    static public function isDirOrMkdir($path)
    {
        if (! is_dir($path)) mkdir($path);
        return $path;
    }

    static public function makePath($uploaddir, $time)
    {
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d', $time);

        $path = static::isDirOrMkdir($uploaddir . '/');
        $path = static::isDirOrMkdir($path . $year . '/');
        $path = static::isDirOrMkdir($path . $month . '/') ;
        $path = static::isDirOrMkdir($path . $day . '/') ;
        return $path;
    }

}