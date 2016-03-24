<?php

class SubrepositoryController extends myController
{

    public function showAction(SubRepository $repository, $page = 1)
    {
        $this->view->page = $this->getPaginatorByQueryBuilder($repository->getAllQueryBuilder(),25,$page);
        $this->view->page->statistics = myParser::getStatistics();
        $this->view->page->repository = myParser::getModelBySourceId($repository->getSubName());
    }
    public function showNoAttachmentAction(SubRepository $repository, $page = 1)
    {
        $this->view->page = $this->getPaginatorByQueryBuilder($repository->getAllNeedsAttachments(),25,$page);
        $this->view->page->statistics = myParser::getStatistics();
        $this->view->page->repository = myParser::getModelBySourceId($repository->getSubName());
    }



    public function showArchiveAction(SubRepository $repository, $month, $page = 1)
    {

        $this->view->page = $this->getPaginatorByQueryBuilder($repository->getArchiveQueryBuilder($month),25,$page);
        $this->view->page->month = $month;
        $this->view->page->repository = myParser::getModelBySourceId($repository->getSubName());
    }

    public function searchAction($repository,$search,$page =1)
    {
//        if(RouterFacade::getMatchedRoute()->getName() == 'subRepository.search')
//            EventFacade::fire('search:sub',$this,['search'=>$search,'repository'=>$repository]);
        $model = myParser::getModelName($repository);
        if(!$model) dd('路径非法，不存在'.$repository.'类型的库');
        $this->view->page = $this->getPaginatorByQueryBuilder(Files::searchQuery($search,$model),50,$page);
        $this->view->search = $search;
    }


}

