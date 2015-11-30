<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/30
 * Time: 20:56
 */
class everySpecParser extends myParser
{

    private $file_id = null;
    public function __construct($file_id = null)
    {
        parent::__construct();
        if($file_id <> null) $this->file_id = $file_id;
    }

    public function parseInfo($file_id = null)
    {
        if($file_id == null) $file_id = $this->file_id;
        $crawler = $this->client->request('get',$this->getUrlFromId($file_id));

        $result = ['source_id'=>$file_id];

        $data = $crawler->filter('h1')->text();
        if (preg_match('/^((?<no>[^,]+),)?\s*(?<title>[^(]+)\((?<date>[^)]+)\)?.*$/m', $data, $regs)) {
            if(isset($regs['no']))$result['standard_no'] = $regs['no'];
            $result['title'] = $regs['title'];
            $result['date'] = $regs['date'];
        }

        $result['abstract'] = $crawler->filter('h1')->nextAll()->last()->text();
        return $result;
    }
    public function getUrlFromId($file_id)
    {
        return base64_decode($file_id);
    }

}