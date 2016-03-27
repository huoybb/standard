<?php

/**
 * 主要充当接口文件以及对象生成器
 * 这种形式与
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
    static protected $parserType = [
        'Periodical'=>webParser\wanfangParser::class,
        'Thesis'=>webParser\wanfangThesisParser::class,
        'Conference'=>webParser\wanfangConferenceParser::class,
        'DoDFile'=>webParser\oai_dtic_mil_parser::class,
        'EverySpec'=>webParser\everySpecParser::class,
        'Citeseerx'=>webParser\citeseerxParser::class,
        'baiduxueshu'=>webParser\baiduxueshuParser::class
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
    function __construct($source_id = null)
    {
        $this->client = new Client();
        $this->source_id = $source_id;
    }

    /**
     * 根据url，抓取网络上的文档信息，并保存到库中
     * @param $source_id
     * @param $type
     * @return FileableTrait|myModel
     */
    public static function grabWebInfoToFile($source_id, $type)
    {
        $parser = myParser::getParser($type,$source_id);//获取Parser
        $data = $parser->parseInfo();//抽取数据

        /** @var myModel|FileableTrait $file */
        $file = new Files();
        $file->save($parser->getDataForFile());//保存file对象

        $data['file_id'] = $file->id;//补充数据，添加file_id
        $model = myParser::getModelBySourceId($type);//获取模型
        $model->save($data);//保存模型数据

        EventFacade::trigger(new addWebFileEvent($model));

        $file->saveFileable($model);//保存关联对象数据
        return $file;
    }

    /**
     * 从网上更新数据库的信息
     * @param Files $file
     * @return Files
     */
    public static function updateFromWeb(Files $file)
    {
        $model = $file->getFileable();
        $parser = static::getParserFromModel($model);
        $data = $parser->parseInfo($model->source_id);

        $file->update($parser->getDataForFile());
        $data['file_id'] = $file->id;//补充数据，添加file_id
        $model->update($data);
        return $file;
    }

    /**针对各个某一个文档的解析
     * @param null $source_id
     * @return mixed
     */
    abstract public function parseInfo($source_id = null);

    /**返回用于Files的数据，这里给出部分，继承对象可以复写部分数据
     * @return array
     */
    public function getDataForFile(){
        $source_id = $this->source_id?:$this->info['source_id'];
        $result =
        [
            'title'=> $this->info['title'],
            'url'=>$this->Id2Url($source_id)
        ];
        if(isset($this->info['doctype'])) $result['type'] = $this->info['doctype'];
        return $result;
    }

    /**id与url转换的函数
     * @param null $source_id
     * @return mixed
     */
    abstract public function Id2Url($source_id = null);

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
//        dd($type);
        if(!isset(self::$modelType[$type])) dd('不存在这个类型'.$type);
        $className = self::$modelType[$type];
//        dd($className);
        if($source_id <> null) return $className::findBySourceId($source_id);
//        if($source_id <> null) return Citeseerx::findBySourceId($source_id);

        return new $className();
    }

    /**
     * @param $modelName
     * @param null $id
     * @return mixed
     */
    public static function getModel($modelName, $id = null)
    {
        $className = $modelName;
        if($id <> null) return $className::findFirst($id);
        return new $className();
    }

    /**根据类型，获取模型名称
     * @param $type
     * @return mixed
     */
    public static function getModelName($type)
    {
        if(!isset(self::$modelType[$type])) dd('不存在这个类型'.$type);
        return self::$modelType[$type];
    }

    /**更具模型名称，获取类型
     * @param $name
     * @return int|string
     */
    public static function getModelType($name)
    {
        foreach(self::$modelType as $key=>$value){
            if($value == $name) return $key;
        }
        dd('不存在子库：'.$name);
    }


    /**获取分库的统计数字
     * @return array
     */
    public  static function getStatistics()
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