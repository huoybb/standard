<?php
use Carbon\Carbon;

/**
 * 这个对象将常见的一些工具集成在这个对象中
 * 有一些直接在volt中变成函数
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/8/29
 * Time: 14:18
 */
class myTools
{
    use myRedisCacheableTrait;
    private $WebName = '';

    public static function isOnline()
    {
        return @fopen("http://www.baidu.com/", "r");//判断是否连上网
    }

    public static function getUrlEncodedToken($token, $user)
    {
        return CryptFacade::encryptBase64($user->id.'::'.$token);
    }

    public static function getUrlDecodedTokenAndUserID($token)
    {
        $token = CryptFacade::decryptBase64($token);
        if (!preg_match('!([0-9]+)::(.+)!', $token, $matches)) {

            dd('Token格式有问题！');
        }
        $user_id = $matches[1];
        $token = $matches[2];
        return [$user_id,$token];
    }

    public function setSiteName($webName)
    {
        $this->WebName = $webName;
    }
    public function getSiteName()
    {
        if(SessionFacade::hasAuth()) return AuthFacade::getService()->name.'的文档库';
        return $this->WebName;
    }

    public function getLayoutLinkArray()
    {
        if(SessionFacade::hasAuth()) {
            list($want, $reading, $done) = [
                AuthFacade::getReadingList('want')->count(),
                AuthFacade::getReadingList('reading')->count(),
                AuthFacade::getReadingList('done', false)->count(),
            ];
        }else{
            list($want, $reading, $done) = [0,0,0];
        }
        $unreadNotification = AuthFacade::getUnreadNotifications()->count();
        return [
            'standards/add'=>'新增',
            'tags'=>'标签','want'=>"想读({$want})",
            'reading'=>"在读({$reading})",
            'done'=>"读过({$done})",
            'notification'=>"通知({$unreadNotification})"
        ];
    }


    public static function formatDate($time)
    {
        if($time == null) return null;
        if (preg_match('/([0-9]+)年([0-9]+)月([0-9]+)日/m', $time, $regs)) {
            return Carbon::create($regs[1],$regs[2],$regs[3])->format('Y-m-d');
        }
        return Carbon::createFromTimestamp(strtotime($time))->format('Y-m-d');
    }



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

    /**
     * @param $month
     * @return Carbon[]
     */
    public static function getBetweenTimes($month)
    {
        $startTime = new Carbon();
        $startTime->setTimestamp(strtotime($month));
        $endTime = clone $startTime;
        $endTime->addMonth();
        return [$startTime,$endTime];
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

    public static function cut($string,$maxLength=50){
//        $result = mb_substr($string,0,$maxLength,'utf-8');
        $result = mb_strcut($string,0,$maxLength,'utf-8');
        if(mb_strlen($string) > $maxLength) $result .= ' ...';
        return $result;
    }

    public static function my_substr($str, $start, $len)
    {
        $tmpstr = "";
        $strlen = $start + $len;
        for($i = 0; $i < $strlen; $i++)
        {
            if( ord( substr($str, $i, 1) ) > 0xa0 )
            {
                $tmpstr .= substr($str, $i, 3);
                $i += 2;
            } else
                $tmpstr .= substr($str, $i, 1);
        }
        return $tmpstr;
    }

    /**
     * @param $search
     * @return boolean
     */
    public function isStandardNumber($search)
    {
        return preg_match('/[a-zA-Z0-9-]+/m', $search);
    }

    public function getLast5SearchedWords()
    {
        $key = 'standard:search:last5';
        return $this->cache($key,Searchlog::getLast5Searched());
    }
    public function getMostSearchedWords()
    {
        $key = 'standard:search:mostSearched5';
        return $this->cache($key,Searchlog::getMostSearched());
    }

    public function getStatistics()
    {
        $key = 'standard:subrepository:statistics';
        return $this->cache($key,myParser::getStatistics());
    }
}