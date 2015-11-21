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
}