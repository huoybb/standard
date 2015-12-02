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
    public static function formatSizeUnits($bytes)
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

    static function storeAttachment(\Phalcon\Http\Request\File $attachment)
    {
        $uploadDir = 'files'; //上传路径的设置
        $time = time();
        $path = myTools::makePath($uploadDir,$time);

        $ext = preg_replace('%^.*?(\.[\w]+)$%', "$1", $attachment->getName()); //获取文件的后缀
        $url = md5($attachment->getName());

        $filename = $path . $time . $url . $ext;

        $attachment->moveTo($filename);

        return $filename;
    }
    /*
     * 接受任何编码，并将之变成UTF-8的编码
     * 这个函数在抓取万方数据有用
     *
     */
    static function correct_encoding($text) {
        $current_encoding = mb_detect_encoding($text, 'auto');
        $text = iconv($current_encoding, 'UTF-8', $text);
        return $text;
    }

    /*
     * 去除页面中的各种不必要的标签
     *
     *
     */
    static function html2txt($document){
        $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript

            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
        );
        $text = preg_replace($search, '', $document);
        return $text;
    }

    public static function cut($string){
        $maxLength = 40;
        $result = mb_substr($string,0,$maxLength,'utf-8');
        if(mb_strlen($string) > $maxLength) $result .= ' ...';
        return $result;
    }

}