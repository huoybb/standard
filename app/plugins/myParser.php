<?php

/**
 * 主要充当接口文件以及对象生成器
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/30
 * Time: 19:53
 */
use Goutte\Client;
abstract class myParser
{
    protected $source_id = null;//标识id
    protected $info = [];//保存parsed后的数据
    function __construct($source_id = null)
    {
        $this->client = new Client();
        $this->source_id = $source_id;
    }
    abstract public function parseInfo($source_id = null);
    abstract public function getDataForFile();
    abstract public function Id2Url($source_id = null);

    static protected $parserType = [
        'Periodical'=>'wanfangParser',
        'Thesis'=>'wanfangThesisParser',
        'Conference'=>'wanfangConferenceParser',
        'DoDFile'=>'oai_dtic_mil_parser',
        'EverySpec'=>'everySpecParser',
    ];

    static protected $modelType = [
        'Periodical'=>'Wanfang',
        'Thesis'=>'Wanfangthesis',
        'Conference'=>'Wanfangconference',
        'DoDFile'=>'OaiDticMil',
        'EverySpec'=>'Everyspec',
    ];

    /**
     * @param $type
     * @param $wanfangId
     * @return myParser
     */
    public static function getParser($type, $wanfangId)
    {
        if(!isset(self::$parserType[$type])) dd('不存在这个类型'.$type);
        $className = self::$parserType[$type];
        return new $className($wanfangId);
    }

    /**
     * @param $type
     * @return  \Phalcon\Mvc\Model
     */
    public static function getModel($type)
    {
        if(!isset(self::$modelType[$type])) dd('不存在这个类型'.$type);
        $className = self::$modelType[$type];
        return new $className();
    }

}