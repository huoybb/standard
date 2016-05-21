<?php

class StandardsController extends myController
{

    public function addAction(Files $file)
    {
        if ($this->request->isPost()) {
            Files::addFile($this->request->getPost());
            return $this->redirectByRoute(['for'=>'index','page'=>1]);
        }
        $this->view->form = myForm::buildFormFromModel($file);
    }

    public function getWebDataAction($type,$source_id)
    {

        $model = myParser::getModelBySourceId($type,$source_id);
        if($model)  return $this->redirectByRoute(['for'=>'standards.show','file'=>$model->getStandard()->id]);

        $file = myParser::grabWebInfoToFile($source_id,$type);
        EventFacade::trigger(new getWebDataEvent($type,$source_id));
        return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
    }

    public function updateFromWebAction(Files $file)
    {
        myParser::updateFromWeb($file);
        return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
    }
    
    public function archiveAction($month,$page = 1)
    {
        $this->view->page = $this->getPaginatorByQueryBuilder(Files::getResultsQueryForMonth($month),25,$page);
        $this->view->page->statistics = myParser::getStatistics();
        $this->view->page->month = $month;
    }

    public function showAction(Files $file)
    {
//        dd(AuthFacade::isSubscribedTo($file));
//        $this->view->cache(true);
//        dd($file->present()->title);
        $this->view->file = $file;
        $this->view->form = myForm::buildCommentForm($file);
    }
    public function readinglogAction(Files $file)
    {
        $this->view->records = $file->getReadingLog();
    }

    public function editAction(Files $file)
    {
        $fileable = $file->getFileable();
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            if(isset($data['file_id'])){ //如果是子库的信息，则应该包含file_id，并以此做判断
                $fileable->update($data);//更新fileable数据表，即子库数据更新
                $file->update(myParser::getParserFromModel($fileable,$data)->getDataForFile());//主库数据更新
                return $this->success();
            }
            $file->update($data);
            return $this->success();
        }

        $extraData = ['doctype'=>$file->type];
        if($fileable == null) {
            $fileable = $file;
            $extraData = null;
        }
        $this->view->file = $file;
        $this->view->form = myForm::buildFormFromModel($fileable,$extraData);
    }

    public function deleteAction(Files $file)
    {
        if ($this->request->isPost()) {
            $file->delete();
            return $this->success();
        }
        $file->delete();
        return $this->redirectByRoute(['for'=>'home']);
    }


    public function searchAction($search,$page = 1)
    {
        
        EventFacade::trigger(new searchEvent($search,AuthFacade::getService()));
        if(myToolsFacade::isStandardNumber($search)) {
            $file = Files::findByStandardNumber($search);
            if($file) return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
        }
//        if(myToolsFacade::isSubrepositorySearch($search)){
//            list($type,$search) = myToolsFacade::getSubrepositorySearch($search);
//            return $this->redirectByRoute(['for'=>'subRepository.search','repository'=>$type,'search'=>$search]);
//        }
        $this->view->page = $this->getPaginatorByQueryBuilder(Files::searchQueryWithFilter($search),50,$page);
        $this->view->search = $search;
        $this->view->JournalsCounts = Files::searchQueryWithJournal($search);
//        dd($this->view->JournalsCounts->toArray());
    }

    public function showSearchItemAction($search,$item)
    {
        EventFacade::trigger(new searchEvent($search,AuthFacade::getService()));
        $this->view->page = $this->getPaginatorByQueryBuilder(Files::searchQuery($search),1,$item);
        $this->view->file = $this->view->page->items[0];
        $this->view->form = myForm::buildCommentForm($this->view->file);
        $this->view->search = $search;

    }


    public function addCommentAction(Files $file)
    {
        if ($this->request->isPost()) {
            $comment = $file->addComment($this->request->getPost());
            EventFacade::trigger(new addCommentEvent($file,$comment));
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
        if ($file->deleteComment($comment)) {
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
            $files = $file->uploadAndStoreAttachment($this->request);
            EventFacade::trigger(new addAttachmentEvent($file,$files));
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
        $file->deleteTag($taggable);
        return $this->redirectByRoute(['for'=>'standards.showTags','file'=>$file->id]);
    }

    public function showTagsAction(Files $file)
    {
        $this->view->file = $file;
    }

    public function addLinkAction(Files $file)
    {
        if($this->request->isPost()){
            $url = $this->request->getPost()['link'];
            $file->addLink($url);
            return 'success';
        }
        return 'failed';
    }

    public function showLinksAction(Files $file)
    {
        $this->view->file = $file;
    }

    public function deleteLinkAction(Files $file,Link $link)
    {
        $file->deleteLink($link);
        return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
    }

    public function addTag2ListAction()
    {
        $data = $this->request->getPost();
        $tagName = $data['tagName'];
        $tag = Tags::findOrNewByName($tagName);

        if(isset($data['file_id'])) {
            $tag->addFileList($data['file_id']);
            return 'success';
        }
        return 'failed';
    }

    public function addRevisionsAction(Files $file,Files $file2)
    {
        if ($file->addRevisionWithAnotherFile($file2)) {
            return $this->success();
        }
        return $this->failed();
    }

    public function combineRevisionsAction()
    {
        $data = $this->request->getPost();
        if(Files::combineRevisions($data['file_id'])) return $this->success();
        return $this->failed();
    }
    public function deleteSelectedFilesAction()
    {
        $data = $this->request->getPost();
        if(count($data['file_id'])){
            $files = Files::query()
                ->inWhere('id',$data['file_id'])
                ->execute();
            $files->delete();
            EventFacade::trigger(new deleteSelectedFilesEvent($files));
            return 'success';
        }
        return 'failed';
    }

    public function relationshipAction(Files $file)
    {
        dd($file);
//        $this->view->file = $file;
    }

    public function addReferenceAction(Files $file,Files $file2)
    {
        $file->addReference($file2);
        return 'success';
    }

    public function getRelationAction(Files $file,$relation)
    {
        $this->view->file = $file;
        $this->view->relation = $relation;
//        dd($file->getRelationDescription($relation));
    }

    public function downloadAttachmentAction()
    {
        $download = new myDownload();
        //生成要下载的文件
        if($this->request->isPost()){
            $filename = 'temp/'.time().'.zip';
            $this->session->set('filename',$filename);
            return $download->createZipFile($this->request->getPost()['file_id'],$filename);
        }
        //下载生成的文件，并删除临时文件
        $filename = $this->session->get('filename');
        $this->session->remove('filename');
        $download->getAndDeleteZipFile($filename);
    }

    public function downloadSingleAttachmentAction($file,Attachments $attachment)
    {
        $download = new myDownload();
        $file_ids = [$file];
        $filename = 'temp/'.time().'.zip';
        $download->createZipFile($file_ids,$filename);
        $download->getAndDeleteZipFile($filename);
    }

    public function subscribeAction(Files $file)
    {
        if(!AuthFacade::isSubscribedTo($file)){
            AuthFacade::subscribe($file);
        }
        return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
    }
    public function unsubscribeAction(Files $file)
    {
        if(AuthFacade::isSubscribedTo($file)){
            AuthFacade::unsubscribe($file);
        }
        return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
    }



}