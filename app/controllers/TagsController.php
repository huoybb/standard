<?php

class TagsController extends myController
{

    public function indexAction($page = 1)
    {
        $tags = Tags::query()
            ->orderBy('updated_at DESC')
            ->execute();
        $this->view->page = $this->getPaginator($tags,25,$page);
    }
    public function showAction(Tags $tag, $page = 1)
    {
//        dd($tag->getTaggedFiles()->count());
        $this->view->mytag = $tag;
        $this->view->page = $this->getPaginator($tag->getTaggedFiles(),25,$page);
//        $this->view->form = $this->buildCommentForm($tag);
        $this->view->form = myForm::buildCommentForm($tag);
    }

    public function editAction(Tags $tag)
    {
        if ($this->request->isPost() && $tag->update($this->request->getPost())) {
            return $this->success();
        }
        $this->view->mytag = $tag;
        $this->view->form = myForm::buildFormFromModel($tag);
    }

    public function addCommentAction(Tags $tag)
    {
        if ($this->request->isPost()) {
            $tag->addComment($this->request->getPost());
            return $this->redirectByRoute(['for'=>'tags.show','tag'=>$tag->id]);
        }
    }
    public function editCommentAction(Tags $tag,Comments $comment)
    {
        if ($this->request->isPost()) {
            $comment->update($this->request->getPost());
            return $this->success();
        }
        $this->view->mytag = $tag;
        $this->view->comment = $comment;
        $this->view->form = myForm::buildCommentForm($tag,$comment);
//        dd($this->view->form);
    }
    public function deleteCommentAction(Tags $tag,Comments $comment)
    {
        $tag->deleteComment($comment);
        return $this->redirectByRoute(['for'=>'tags.show','tag'=>$tag->id]);
    }

    public function showItemAction(Tags $tag,$item)
    {
        $this->view->mytag = $tag;
        $this->view->page = $this->getPaginator($tag->getTaggedFiles(),1,$item);
        $this->view->file = $this->view->page->items[0]->files;
        $this->view->form = myForm::buildCommentForm($this->view->file);
    }

    public function deleteItemAction($tag,Taggables $taggable)
    {
        $taggable->delete();
        return $this->redirectByRoute(['for'=>'tags.show','tag'=>$tag]);
    }

    public function deleteAction(Tags $tag)
    {
        foreach($tag->taggables() as $taggable){
            $taggable->delete();
        }
        $tag->delete();
        return $this->redirectByRoute(['for'=>'home']);
    }


}
