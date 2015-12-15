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
            ->orderBy('Files.id DESC');
        $this->view->page = $this->getPaginatorByQueryBuilder($builder,25,$page);
        $this->view->page->statistics = myParser::getStatistics();
        $this->view->page->repository = myParser::getModel($repository);
    }


}

