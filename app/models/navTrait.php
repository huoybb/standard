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
        return  $this->make('next',function(){
            /** @var myModel $this */
            $row = self::findFirst(['id > :id:','bind'=>['id'=>$this->id],'order'=>'id ASC']);
            if(null == $row) $row =self::findFirst();
            return $row;
        });
    }

    public function getPrevious()
    {
        return $this->make('before',function(){
            /** @var myModel $this */
            $row = self::findFirst(['id<:id:','bind'=>['id'=>$this->id],'order'=>'id DESC']);
            if(null == $row) $row = self::findFirst(['order'=>'id DESC']);
            return $row;
        });
    }
}