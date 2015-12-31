<?php

class SubrepositoryController extends myController
{

    public function indexAction()
    {

    }

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



}

