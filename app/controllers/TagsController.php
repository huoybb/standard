<?php

class TagsController extends myController
{

    public function indexAction($page = 1,Tags $tag)
    {
        $this->view->page = $this->getPaginator(Tags::getAllTags(),25,$page);
    }
    public function showAction(Tags $tag, $page = 1)
    {
        $this->view->mytag = $tag;
        $this->view->page = $this->getPaginator($tag->getTaggedFiles(),25,$page);
        $this->view->form = myForm::buildCommentForm($tag);
    }

    public function showArchiveAction(Tags $tag,$month,$page = 1)
    {
        $this->view->mytag = $tag;
        $this->view->page = $this->getPaginator($tag->getTaggedFilesByMonth($month),25,$page);
        $this->view->form = myForm::buildCommentForm($tag);
        $this->view->page->month = $month;
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
            $comment = $tag->addComment($this->request->getPost());
            EventFacade::trigger(new addCommentEvent($tag,$comment));
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

    public function showItemAction(Tags $tag,Files $file)
    {
        $this->view->mytag = $tag;
        $this->view->page = $tag->getShowItemPage($file);
        $this->view->file = $file;
        $this->view->form = myForm::buildCommentForm($file->getTaggable($tag)->getFirst());
    }
    public function commentItemAction(Taggables $taggable)
    {
        $comment = $taggable->addComment($this->request->getPost());
        EventFacade::trigger(new addCommentEvent($taggable,$comment));

        return $this->redirectBack();
    }


    public function deleteItemAction($tag,Taggables $taggable)
    {
        /** @var Files $file */
        $file = $taggable->getTagged();
        $file->deleteTag($taggable);
        return $this->redirectByRoute(['for'=>'tags.show','tag'=>$tag]);
    }

    public function deleteAction(Tags $tag)
    {
        $tag->deleteByCurrentUser();
        return $this->redirectByRoute(['for'=>'home']);
    }

    public function addAttachmentAction(Tags $tag)
    {
        if ($this->request->hasFiles() == true) {
            $files = $tag->uploadAndStoreAttachment($this->request);
            EventFacade::trigger(new addAttachmentEvent($tag,$files));
            return $this->success();
        }else{
            return $this->failed();
        }
    }

    public function showAttachmentsAction(Tags $tag)
    {
        $this->view->mytag = $tag;

    }

    public function deleteAttachmentAction(Tags $tag,Attachments $attachment)
    {
        $tag->deleteAttachment($attachment);
        return $this->redirectByRoute(['for'=>'tags.show','tag'=>$tag->id]);
    }

    public function deleteTaggableItemsAction(Tags $tag)
    {
        $data = $this->request->getPost();
        if($tag->softDeleteFiles($data['file_id'])) return $this->success();
        return $this->failed();
    }

    public function addLinkAction(Tags $tag)
    {
        $data = $this->request->getPost();
        $tag->addLink($data['link']);
        return $this->redirectByRoute(['for'=>'tags.show','tag'=>$tag->id]);
    }
    public function showLinksAction(Tags $tag)
    {
        $this->view->mytag = $tag;
    }

    public function deleteLinkAction(Tags $tag,Link $link)
    {
        $tag->deleteLink($link);
        return $this->redirectBack();
    }

    public function addReferenceAction(Tags $tag,Tags $tag2)
    {
        $tag->addReference($tag2);
        return 'success';
    }

    public function getRelationAction(Tags $tag,$relation)
    {
        $this->view->mytag = $tag;
        $this->view->relation = $relation;
    }
    public function referencesAction(Tags $tag)
    {
        $this->view->references = $tag->getReferences();
        $this->view->mytag = $tag;
    }

    public function deleteReferenceAction(Tags $tag,Tags $reference)
    {
        $relation = Relationship::query()
            ->where('start_id = :start_id:',['start_id'=>$reference->id])
            ->andWhere('start_type = :start_type:',['start_type'=>get_class($reference)])
            ->andWhere('end_id = :end_id:',['end_id'=>$tag->id])
            ->andWhere('end_type = :end_type:',['end_type'=>get_class($tag)])
            ->execute();
        $relation->delete();
        return $this->redirectByRoute(['for'=>'tags.references','tag'=>$tag->id]);
    }



    public function subscribeAction(Tags $tag)
    {
        if(!AuthFacade::isSubscribedTo($tag)){
            AuthFacade::subscribe($tag);
        }
        return $this->redirectByRoute(['for'=>'tags.show','tag'=>$tag->id]);
    }

    public function unsubscribeAction(Tags $tag)
    {
        if(AuthFacade::isSubscribedTo($tag)){
            AuthFacade::unsubscribe($tag);
        }
        return $this->redirectByRoute(['for'=>'tags.show','tag'=>$tag->id]);
    }
}
