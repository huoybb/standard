<?php

class StandardsController extends myController
{

    public function indexAction()
    {

    }
    public function addAction(Files $file)
    {
        if ($this->request->isPost()) {
//            dd($this->request->getPost());
            $file->save($this->request->getPost());
            $this->redirectByRoute(['for'=>'index','page'=>1]);
        }
        $this->view->form = myForm::buildFormFromModel($file);

    }

    public function addDoDAction(Files $file)
    {
//        dd($this->request->getPost());
        $file_id = $this->request->getPost()['file_id'];
        if($this->request->isPost() ){
            $this->addDoDFile($file_id,$file);
        }
        dd('非法路径，不允许直接访问该地址');

    }

    public function addDoDByGetAction($accessNumber,Files $file)
    {
        $this->addDoDFile($accessNumber,$file);
    }



    public function showAction(Files $file)
    {
        $this->view->file = $file;
        $this->view->form = myForm::buildCommentForm($file);
    }



    public function editAction(Files $file)
    {
        if ($this->request->isPost()) {
            $file->update($this->request->getPost());
            return $this->success();
        }
        $this->view->file = $file;
        $this->view->form = myForm::buildFormFromModel($file);
    }

    public function deleteAction(Files $file)
    {
        if ($this->request->isPost()) {
            $file->delete();
            return $this->success();
        }

    }


    public function searchAction($search,$page = 1,Files $file)
    {
//        $this->view->page = $this->getPaginator($file->search($search),50,$page);
        $this->view->page = $this->getPaginatorByQueryBuilder($file->searchQuery($search),50,$page);
        $this->view->search = $search;
    }

    public function showSearchItemAction($search,$item,Files $file)
    {
//        $page = $this->getPaginatorByQueryBuilder($file->searchQuery($search),1,$item);

        $this->view->page = $this->getPaginatorByQueryBuilder($file->searchQuery($search),1,$item);
        $this->view->file = $this->view->page->items[0];
        $this->view->form = myForm::buildCommentForm($this->view->file);
        $this->view->search = $search;

    }


    public function addCommentAction(Files $file)
    {
        if ($this->request->isPost() && $this->addCommentTo($file)) {
            return $this->success();
        }
        dd('添加评论出错啦！');
    }
    public function editCommentAction(Files $file,Comments $comment)
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            if ($comment->update($data)) {
                return $this->success();
            }
            dd('评论更新失败');
        }
        $this->view->file = $file;
        $this->view->comment = $comment;
        $this->view->form =myForm::buildCommentForm($file,$comment);
    }

    public function deleteCommentAction(Files $file,Comments $comment)
    {
        if ($comment->delete()) {
            return $this->success();
        }
    }



    //附件相关的控制
    public function showAttachmentsAction(Files $file)
    {
//        dd($file->attachments()->toArray());
        $this->view->file = $file;
    }

    public function addAttachmentAction(Files $file)
    {
        if ($this->request->hasFiles() == true) {
            $file->uploadAndStoreAttachment($this->request);
            return $this->success();
        }else{
            return $this->failed();
        }

    }
    
    public function editAttachmentAction(Files $file,Attachments $attachment)
    {
        dd($attachment->toArray());
    }

    public function deleteAttachmentAction(Files $file,Attachments $attachment)
    {
        $file->deleteAttachment($attachment);
        return $this->redirectByRoute(['for'=>'standards.showAttachments','file'=>$file->id]);
    }


    //标签相关操作
    public function addTagAction(Files $file)
    {
        $tag = Tags::findOrNewByName($this->request->getPost()['tagName']);
        $file->addTag($tag);
        return $this->success();
    }

    public function deleteTagAction(Files $file,Taggables $taggable)
    {
        $this->deleteTaggable($taggable);
        return $this->redirectByRoute(['for'=>'standards.showTags','file'=>$file->id]);
    }

    public function showTagsAction(Files $file)
    {
        $this->view->file = $file;
    }


    public function addRevisionsAction(Files $file,Files $file2)
    {
        if ($this->addRevisionsToTwofiles($file,$file2)) {
            return $this->success();
        }
    }






    private function addRevisionsToTwofiles(Files $file1,Files $file2)
    {
        $rev1 = $file1->getRevision();
        $rev2 = $file2->getRevision();

        //如果两个都是空的
        if($rev1 == null && $rev2 == null){
            $rev1 = new Revisions();
            $rev1->save([
                'file_id'=> $file1->id,
                'name'=> $file1->title
            ]);
            $rev1->update([
                'parent_id'=>$rev1->id
            ]);

            $rev2 = new Revisions();
            $rev2->save([
                'file_id'=>$file2->id,
                'parent_id'=>$rev1->id,
                'name'=>$file2->title
            ]);
            return true;
        }
        //如果其中一个是空的
        if($rev1 <> null && $rev2 == null){
            $rev2 = new Revisions();
            $rev2->save([
                'file_id'=>$file2->id,
                'parent_id'=>$rev1->parent_id,
                'name'=>$file2->title
            ]);
            return true;
        }

        if($rev1 == null && $rev2 <> null){
            $rev1 = new Revisions();
            $rev1->save([
                'file_id'=>$file1->id,
                'parent_id'=>$rev2->parent_id,
                'name'=>$file1->title
            ]);
            return true;
        }

        //如果两个都不是空的

        if($rev1 <> null && $rev2 <> null){
            $rev2->getAllRevisions()->update(['parent_id'=>$rev1->parent_id]);
            return true;
        }


        return false;
    }

    private function deleteTaggable(Taggables $taggable)
    {
        $tag = $taggable->tag();
        $taggable->delete();
        if($tag->tagCounts() == 0){
            $tag->delete();
        }
    }

    private function addDoDFile($accessNumber, Files $file)
    {
        $dod = OaiDticMil::findByAccessNo($accessNumber);
        if($dod) return  $this->redirectByRoute(['for'=>'standards.show','file'=>$dod->getStandard()->id]);
        $file->saveDoDFile($accessNumber);
        return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
    }
}