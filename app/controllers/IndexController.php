<?php

class IndexController extends myController
{

    public function indexAction($page = 1)
    {

        $builder = $this->modelsManager->createBuilder()
            ->from('Files')
            ->orderBy('id DESC');
        $this->view->page = $this->getPaginatorByQueryBuilder($builder,25,$page);
        $this->view->page->statistics = myParser::getStatistics();
    }
}

