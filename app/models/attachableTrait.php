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
                ->where('attachable_id = :id:',['id'=>$this->id])
                ->andWhere('attachable_type = :type:',['type'=>get_class($this)])
                ->orderBy('created_at DESC')
                ->execute();
        });
    }
    public function deleteAttachment(Attachments $attachment)
    {
        /** @var myModel $this */
        $attachment->delete();
        $this->decreaseCount('attachmentCount');
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
            $data['attachable_id'] = $this->id;
            $data['attachable_type'] = get_class($this);
            (new Attachments())->save($data);
            
            $this->increaseCount('attachmentCount');
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