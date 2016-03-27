<?php


use Phalcon\Di;
use Phalcon\Cache\Frontend\Output as FrontOutput;
use Phalcon\Tag;

class IndexController extends myController
{

    public function indexAction($page = 1)
    {

        $this->view->page = $this->getPaginatorByQueryBuilder(Files::getAllQueryBuilder(),25,$page);
    }
}