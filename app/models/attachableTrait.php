<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/22
 * Time: 6:48
 */
trait attachableTrait
{
    public function hasAttachments()
    {
        return $this->attachmentCount > 0;
    }

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

        EventFacade::fire(strtolower(get_class($this)).':deleteAttachment',$this);
        return $this;
    }

    public function uploadAndStoreAttachment(\Phalcon\Http\Request $request)
    {
        /** @var myModel $this */

        $files = [];
        foreach($request->getUploadedFiles() as $f){
            $data = [];
            $data['name'] = $f->getName();
            $data['url']=myTools::storeAttachment($f);
            $data['user_id'] = AuthFacade::getID();
            $data['attachable_id'] = $this->id;
            $data['attachable_type'] = get_class($this);

            $attachment = (new Attachments());
            $attachment->save($data);

            $files[] = $attachment;
        }

        EventFacade::fire(strtolower(get_class($this)).':addAttachment',$this,$files);

        return $this;
    }

    public function beforeDeleteForAttachments()
    {
        $attachments = $this->attachments();
        if($attachments) $attachments->delete();
        return $this;
    }



}