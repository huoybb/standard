<?php

class RevisionsController extends myController
{

    public function indexAction()
    {

    }
    public function showAction(Revisions $rev)
    {
        $this->view->rev=$rev;
    }
    public function deleteAction(Revisions $rev)
    {
        $remain = $rev->deleteCurrentAndGetRemain();
        if($remain){
            return $this->redirectByRoute(['for'=>'revisions.show','rev'=>$remain->id]);
        } else{
            return $this->response->redirect('/');
        }
    }



}

