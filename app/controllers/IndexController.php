<?php


class IndexController extends myController
{

    public function indexAction($page = 1)
    {
        $this->view->page = $this->getPaginatorByQueryBuilder(Files::getAllQueryBuilder(),25,$page);
        $this->view->page->statistics = myParser::getStatistics();
    }
}

