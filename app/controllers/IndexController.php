<?php

class IndexController extends myController
{

    public function indexAction($page = 1)
    {

        \PhalconDebug::startMeasure('s0','控制器加载');
        $builder = $this->modelsManager->createBuilder()
            ->from('Files')
            ->orderBy('id DESC');
        $this->view->page = $this->getPaginatorByQueryBuilder($builder,25,$page);
        $this->view->page->statistics = myParser::getStatistics();
        \PhalconDebug::stopMeasure('s0');
    }
}

