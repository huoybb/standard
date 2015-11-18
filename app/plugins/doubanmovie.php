<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/7/18
 * Time: 6:55
 */
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class doubanmovie {
    private $filmField =[
        'title'=>'片名',
        'poster'=>'海报图片',
        'director'=>'导演',
        'screenwriter'=>'编剧',
        'casts'=>'主演',
        'official_website'=>'官方网站',
        'country'=>'制片国家/地区',
        'language'=>'语言',
        'release_time'=>'上映日期',
        'other_names'=>'又名',
        'IMDb_link'=>'IMDb链接',
        'doubanid'=>'doubanid'
    ];


    function __construct()
    {
        $this->client = new Client();
    }

    public function getinfo($doubanid)
    {
        $movie_url = $this->geturl($doubanid);
        $data = $this->parseinfo($movie_url);
        $data['doubanid'] = $doubanid;
        return $this->getdata($data);
    }

    /**
     * 负责将数据从网页中解析出来
     * @param $movie_url
     * @return array
     */
    private  function parseinfo($movie_url)
    {
        $crawler = $this->client->request('get',$movie_url);
//        dd($crawler);
        $dom = $crawler->filter('#info');
//        dd($dom->count());
        if($dom->count()) {
            $info = $crawler->filter('#info')->html();
        }else{
//            $html = file_get_contents($movie_url);
//            $crawler = new Crawler();
//            $crawler->add($html);
//            $info = $crawler->filter('#info');
            var_dump($crawler->html());die();
        }
//        dd($info);
        $info = $this->removeTags($info);
        $result = explode('<br>',$info);

        $data = [];
        $data['片名']=$this->removeTags($crawler->filter('h1')->text());
        $data['海报图片']= str_replace('spst','lpst',$crawler->filter('#mainpic img')->attr('src'));

        //获取海报图片，并存放在
        $poster = (new getpic())->get($data['海报图片']);
        if(isset($poster['newurl'])) $data['海报图片'] = $poster['newurl'];

        foreach($result as $row){
            if($row <> ''){
                list($key,$value) = explode(':',$row);
                $data[trim($key)]=trim($value);
            }
        }

        if(isset($data['季数'])){
            $seasons = [];
            $crawler->filter('#season option')->each(function($season) use(&$seasons){
                $seasons[$season->text()]= $season->attr('value');
            });
            $data['季数'] = $seasons;
        }

        return $data;
    }

    /**帮助函数，去除info中无用的html标签
     * @param $info
     * @return string
     */
    private function removeTags($info)
    {
        $info = strip_tags($info,'<br>');
        $info = preg_replace('/\s+/', ' ', $info);
        return trim($info);
    }

    /**
     * 负责将数据按照规定的格式挑选出来
     * @param $data
     * @return array
     */
    private  function getdata($data)
    {

        $d =[];
        foreach($this->filmField as $key => $value){
            if(isset($data[$value])) $d[$key]=$data[$value];
        }
        return $d;
    }

    private function geturl($doubanid)
    {
        return 'http://movie.douban.com/subject/'.$doubanid.'/';
    }
} 