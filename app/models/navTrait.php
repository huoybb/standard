<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/22
 * Time: 7:25
 */
trait navTrait
{
    public function getNext()
    {
        /** @var myModel $this */
        return  $this->make('next',function(){
            $row = self::findFirst(['id > :id:','bind'=>['id'=>$this->id],'order'=>'id ASC']);
            if(null == $row) $row =self::findFirst();
            return $row;
        });
    }

    public function getPrevious()
    {
        /** @var myModel $this */
        return $this->make('before',function(){
            $row = self::findFirst(['id<:id:','bind'=>['id'=>$this->id],'order'=>'id DESC']);
            if(null == $row) $row = self::findFirst(['order'=>'id DESC']);
            return $row;
        });
    }
}