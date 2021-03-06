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
            EventFacade::fire('standards:addFile',$file);
            return $this->redirectByRoute(['for'=>'index','page'=>1]);
        }
        $this->view->form = myForm::buildFormFromModel($file);
    }

    public function addDoDAction(Files $file)
    {
//        dd($this->request->getPost());
        if($this->request->isPost()){
            $file_id = $this->request->getPost()['file_id'];
            return $this->addDoDFile($file_id,$file);
        }
        dd('非法路径，不允许直接访问该地址');

    }


    public function getWebDataAction($type,$source_id,Files $file)
    {
//        $parser = myParser::getParser($type,$source_id);//获取Parser
////        dd($parser);
//        $data = $parser->parseInfo();//抽取数据
//        dd($data);

        $model = myParser::getModelBySourceId($type,$source_id);
        if($model)  return $this->redirectByRoute(['for'=>'standards.show','file'=>$model->getStandard()->id]);

        $file->addWebFile($source_id,$type);
        return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
    }

    public function archiveAction($month,$page = 1,Files $file)
    {
        list($startTime,$endTime) = myTools::getBetweenTimes($month);
        $this->view->page = $this->getPaginatorByQueryBuilder($file->getResultsBetween($startTime,$endTime),25,$page);
        $this->view->page->statistics = myParser::getStatistics();
        $this->view->page->month = $month;
    }

    public function showAction(Files $file)
    {

//        $router = $this->router;
//        $router->handle('/search/装备');
//        dd($router->getMatchedRoute());  为什么单独测试可以呢？

        $this->view->file = $file;
        $this->view->form = myForm::buildCommentForm($file);
    }


    public function editAction(Files $file)
    {
        $fileable = $file->getFileable();
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
//            dd($data);
            if(isset($data['file_id'])){
                $fileable->update($data);//更新fileable数据表
                $file_data = myParser::getParserFromModel($fileable,$data)->getDataForFile();
                $file_data['type'] = $data['type'];
                $file->update($file_data);
                return $this->success();
            }

            $file->update($this->request->getPost());
            return $this->success();
        }

        $this->view->file = $file;
        if($fileable == null) $fileable = $file;
        $this->view->form = myForm::buildFormFromModel($fileable,['type']);
    }

    public function deleteAction(Files $file)
    {
        EventFacade::fire('standards:deleteFile',$file);
        if ($this->request->isPost()) {
            $file->delete();
            return $this->success();
        }
//        dd($file);
        $file->delete();
        return $this->redirectByRoute(['for'=>'home']);
    }


    public function searchAction($search,$page = 1)
    {
//        $this->view->page = $this->getPaginator($file->search($search),50,$page);
        if($this->isStandardNumber($search)) {
            $file = Files::findByStandardNumber($search);
            if($file) return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
        }
        $this->view->page = $this->getPaginatorByQueryBuilder(Files::searchQuery($search),50,$page);
        $this->view->search = $search;
    }

    public function showSearchItemAction($search,$item)
    {
        $this->view->page = $this->getPaginatorByQueryBuilder(Files::searchQuery($search),1,$item);
        $this->view->file = $this->view->page->items[0];
        $this->view->form = myForm::buildCommentForm($this->view->file);
        $this->view->search = $search;

    }


    public function addCommentAction(Files $file)
    {
        if ($this->request->isPost()) {
            $file->addComment($this->request->getPost());
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
            EventFacade::fire('standards:deleteSelectedFiles',$files);
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


    private function addDoDFile($accessNumber, Files $file)
    {
        $dod = OaiDticMil::findBySourceId($accessNumber);
        if($dod) return  $this->redirectByRoute(['for'=>'standards.show','file'=>$dod->getStandard()->id]);
        $file->addWebFile($accessNumber,'DoDFile');
        return $this->redirectByRoute(['for'=>'standards.show','file'=>$file->id]);
    }

    private function isStandardNumber($search)
    {
        return preg_match('/[a-zA-Z0-9-]+/m', $search);
    }

}