<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/22
 * Time: 14:27
 */
use Goutte\Client;
class oai_dtic_mil_parser
{

    function __construct()
    {
        $this->client = new Client();
    }
    public function parseInfo($file_id)
    {
        $result = [];
        $crawler = $this->client->request('get',$this->getURLById($file_id));
        $crawler->filter('p')->each(function($info) use(&$result){
            /** @var Symfony\Component\DomCrawler\Crawler $info */
            if (preg_match('%<b>\s*([^:]+?)\s*:.*?</b>(.+)$%sm', $info->html(), $regs)) {
                $name = $regs[1];
                $name = str_replace(' ','_',$name);
                $name = str_replace('(s)','',$name);

                $value = $regs[2];
                $result[$name] = $value;
            }
        });
        return $result;
    }

    public function getURLById($id)
    {
        return 'http://oai.dtic.mil/oai/oai?verb=getRecord&metadataPrefix=html&identifier='.$id;
    }


}