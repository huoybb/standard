<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/22
 * Time: 6:48
 */
trait attachableTrait
{
    public function attachments()
    {
        /** @var myModel $this */
        return $this->make('attachments',function(){
            return Attachments::query()
                ->where('file_id = :id:',['id'=>$this->id])
                ->orderBy('created_at DESC')
                ->execute();
        });
    }
    public function deleteAttachment(Attachments $attachment)
    {
        $attachment->delete();
        return $this;
    }

    public function uploadAndStoreAttachment(\Phalcon\Http\Request $request)
    {
        /** @var myModel $this */
        foreach($request->getUploadedFiles() as $f){
            $data = [];
            $data['name'] = $f->getName();
            $data['url']=myTools::storeAttachment($f);
            $data['user_id'] = 1;
            $data['file_id'] = $this->id;
            (new Attachments())->save($data);
        }
        return $this;
    }

    public function beforeDeleteForAttachments()
    {
        $attachments = $this->attachments();
        if($attachments) $attachments->delete();
        return $this;
    }



}