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
        $parent_id = $rev->parent_id;
        $rev->delete();
        $remain = Revisions::findFirst(['parent_id = :id:','bind'=>['id'=>$parent_id]]);
        if($remain){
            return $this->redirectByRoute(['for'=>'revisions.show','rev'=>$remain->id]);
        } else{
            return $this->response->redirect('/');
        }
    }



}

