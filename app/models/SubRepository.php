<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/17
 * Time: 5:52
 */
class SubRepository
{
    private $sub;
    private $modelsManager;
    /**
     * Repository constructor.
     * @param $sub
     */
    public function __construct($sub)
    {
        $this->sub = $sub;
        $this->modelsManager = \Phalcon\Di::getDefault()->get('modelsManager');
    }
    /**
     * @return string
     */
    public function getSubName()
    {
        return $this->sub;
    }

    public function getAllQueryBuilder()
    {
        $subClassname = myParser::getModelName($this->sub);
//        dd($subClassname);

        $builder = $this->modelsManager->createBuilder()
            ->from('Files')
            ->rightJoin($subClassname,'sub.file_id = Files.id','sub')
//            ->where('Files.attachmentCount = 0')
            ->orderBy('Files.id DESC')
            ->columns(['Files.*','sub.*']);
        return $builder;
    }

    public function getAllNeedsAttachments()
    {
        return $this->getAllQueryBuilder()->where('Files.attachmentCount = 0');
    }

    public function getArchiveQueryBuilder($month)
    {
        /** @var \Carbon\Carbon $startTime */
        /** @var \Carbon\Carbon $endTime */
        list($startTime,$endTime) = myTools::getBetweenTimes($month);

        $builder = $this->modelsManager->createBuilder()
            ->from('Files')
            ->rightJoin(myParser::getModelName($this->sub),'sub.file_id = Files.id','sub')
            ->where('created_at BETWEEN :start: AND :end:',['start'=>$startTime->toDateTimeString(),'end'=>$endTime->toDateTimeString()])
            ->orderBy('Files.id DESC')
            ->columns(['Files.*','sub.*']);

        return $builder;
    }


    


}