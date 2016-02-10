<?php

class SubrepositoryController extends myController
{

    public function showAction($repository,$page = 1)
    {
        $builder = $this->modelsManager->createBuilder()
            ->from('Files')
            ->rightJoin(myParser::getModelName($repository),'sub.file_id = Files.id','sub')
            ->orderBy('Files.id DESC')
            ->columns(['Files.*','sub.*']);
        $this->view->page = $this->getPaginatorByQueryBuilder($builder,25,$page);
        $this->view->page->statistics = myParser::getStatistics();
        $this->view->page->repository = myParser::getModelBySourceId($repository);
    }

    public function showArchiveAction($repository,$month,$page = 1)
    {
        list($startTime,$endTime) = myTools::getBetweenTimes($month);

        $builder = $this->modelsManager->createBuilder()
            ->from('Files')
            ->rightJoin(myParser::getModelName($repository),'sub.file_id = Files.id','sub')
            ->where('created_at > :start:',['start'=>$startTime->toDateTimeString()])
            ->andWhere('created_at < :end:',['end'=>$endTime->toDateTimeString()])
            ->orderBy('Files.id DESC')
            ->columns(['Files.*','sub.*']);
        $this->view->page = $this->getPaginatorByQueryBuilder($builder,25,$page);
        $this->view->page->month = $month;
        $this->view->page->repository = myParser::getModelBySourceId($repository);
    }

    public function searchAction($repository,$search,$page =1)
    {
        $model = myParser::getModelName($repository);
        if(!$model) dd('路径非法，不存在'.$repository.'类型的库');
        $this->view->page = $this->getPaginatorByQueryBuilder(Files::searchQuery($search,$model),50,$page);
        $this->view->search = $search;
    }


}

