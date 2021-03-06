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
        'Periodical'=>wanfangParser::class,
        'Thesis'=>wanfangThesisParser::class,
        'Conference'=>wanfangConferenceParser::class,
        'DoDFile'=>oai_dtic_mil_parser::class,
        'EverySpec'=>everySpecParser::class,
        'Citeseerx'=>citeseerxParser::class,
        'baiduxueshu'=>baiduxueshuParser::class
    ];

    static protected $modelType = [
        'Periodical'=>Wanfang::class,
        'Thesis'=>Wanfangthesis::class,
        'Conference'=>Wanfangconference::class,
        'DoDFile'=>OaiDticMil::class,
        'EverySpec'=>Everyspec::class,
        'Citeseerx'=>Citeseerx::class,
        'baiduxueshu'=>Baiduxueshu::class,
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
     * @param FileableInterface $model
     * @param null $data
     * @return myParser
     */
    public static function getParserFromModel(FileableInterface $model, $data = null){
        $modelName = get_class($model);
        $reverseModelType = array_flip(self::$modelType);
        $object = new self::$parserType[$reverseModelType[$modelName]];
        if($data <> null) $object->info = $data;
        return $object;
    }

    /**
     * 如果source_id等于null，则返回新对象，否则就按照source_id查询对应的对象
     * @param $type
     * @return  \Phalcon\Mvc\Model|FileableInterface
     */
    public static function getModelBySourceId($type, $source_id = null)
    {
//        dd($type.' '.$source_id);
        if(!isset(self::$modelType[$type])) dd('不存在这个类型'.$type);
        $className = self::$modelType[$type];
//        dd($className);
        if($source_id <> null) return $className::findBySourceId($source_id);
//        if($source_id <> null) return Citeseerx::findBySourceId($source_id);

        return new $className();
    }
    public static function getModel($type, $id = null)
    {
        $className = $type;
        if($id <> null) return $className::findFirst($id);
        return new $className();
    }

    public static function getModelName($type)
    {
        if(!isset(self::$modelType[$type])) dd('不存在这个类型'.$type);
        return self::$modelType[$type];
    }

    public static function getModelType($name)
    {
        foreach(self::$modelType as $key=>$value){
            if($value == $name) return $key;
        }
        dd('不存在子库：'.$name);
    }



    public static function getStatistics()
    {
        $result = [];
        $data = Fileable::query()
            ->groupBy('fileable_type')
            ->columns(['count(file_id) AS count','fileable_type AS type'])
            ->execute();
        foreach($data as $row){
            $className = $row->type;
            $result[] = [
                'name' => $className::getDatabaseName(),
                'count'=> $row->count,
                'type' => myParser::getModelType($className)
            ];
        }
        return $result;
    }
}