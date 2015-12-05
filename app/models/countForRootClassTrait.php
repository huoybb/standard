<?php

/**
 * 这个Trait是给领域模型中Root对象使用的，主要是针对Root中各种count记录的操作
 * 这些count属性主要是用来减少对数据库查询而设置的
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/5
 * Time: 10:45
 */
trait countForRootClassTrait
{
    public function decreaseCount($field)
    {
        /** @var myModel $this */
        $this->$field -=1;
        return $this->save();
    }

    public function increaseCount($field)
    {
        /** @var myModel $this */
        $this->$field +=1;
        return $this->save();
    }
}