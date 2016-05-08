<?php

class JournalsController extends myController
{

    public function indexAction()
    {
        dd('待实现');
    }

    public function showAction($journal,$page = 1)
    {
        $this->view->journal = $journal;
        $this->view->page = $this->getPaginator(Wanfang::getByJournal($journal),25,$page);
    }


}

