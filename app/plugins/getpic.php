<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/7/18
 * Time: 6:59
 */

class getpic{
    public function get($url)
    {
        set_time_limit(60 * 10); //设置程序超时时间10分钟内应该能够下载完成
        $context =$this->getContext($url);
        $img = @file_get_contents($url, null, $context); //这里file_get_contents和file_put_contents这两个函数非常好用，看来以后抓取图片就直接可以使用这两个函数了，看了一下帮助是三个函数的合成
        $fname = $this->storepic($img,$url);
        return [
            'url' => $url,
            'newurl' => $fname
        ];//返回新旧图片的地址数组

    }

    private function getReferer($url)
    {
        $Referer = preg_replace('!^(http://[^\/]*)/.*!', '$1',$url);  //设置默认referer

        /** @var  $urlBlocker .整个数组可以不断增加，以便将所见到的各种对图片的封锁都能够破解出来*/
        $urlBlocker = array(
            array('url' => 'http://static\d+.photo.sina.com.cn',
                'Referer' => 'http://blog.sina.com.cn/s/'),  //获取新浪博客图片的时候需要的地址
            array('url' => 'http://img.cnbeta.com/',
                'Referer' => 'http://www.cnbeta.com/articles/'),  //在cnbeta网上获取图片的时候需要的地址
            array('url' => 'http://files.xici.net/',
                'Referer' => 'http://www.xici.net/'),  //看来西祠这个网站的防盗链挺特殊的！有时间研究一下
            array('url' => 'http://img.iplaysoft.com/wp-content/uploads/',
                'Referer' => 'http://www.iplaysoft.com/')
        );
        foreach ($urlBlocker as $b) {
            if (preg_match('%' . $b['url'] . '%',$url))
                $Referer = $b['Referer'];
        }
        return $Referer;
    }

    private function getContext($url)
    {
        $Referer = $this->getReferer($url);
        $opts = array(
            'http' => array('method' => "GET",
                'header' => "Referer: " . $Referer . "/\r\n"));
        return stream_context_create($opts); //根据上述参数生成header参数，看来HTTP协议还是非常容易欺骗的，哈哈！

    }

    private function storepic($img,$url)
    {
        if ($img == null) return NULL;//        die('No image has been downloaded!');
        $uploadDir = './files'; //上传路径的设置

        $time = time();
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d', $time);

        $path = $this->getpath($uploadDir,$year,$month,$day);


        $ext = preg_replace('%^.*?(\.[\w]+)$%', "$1", $url); //获取文件的后缀
        if ($ext == $url)
            $ext = ''; //此处没有经过测试，怀疑！如果获取的是整个文件的话，则设置文件后缀是空
        $url2 = md5($url); //之前是用正则的方法，将文件名字中的特殊字符取出，这里其实是采用md5散列的方式将文件名字密化
        $filename = $path . $time . $url2 . $ext;
        file_put_contents($filename, $img);
//        $fname = preg_replace('%^E:/WWW/web/(.*)$%', '$1', $fname); //将文件路径与网站路径对应上
        return $filename;
    }


    private function isDirOrMkdir($path)
    {
        if (! is_dir($path)) mkdir($path);
        return $path;
    }

    private function getpath($uploaddir, $year, $month, $day)
    {
        $path = $this->isDirOrMkdir($uploaddir . '/');
        $path = $this->isDirOrMkdir($path. $year . '/');
        $path = $this->isDirOrMkdir($path.$month . '/') ;
        $path = $this->isDirOrMkdir($path.$day . '/') ;
        return $path;
    }


}