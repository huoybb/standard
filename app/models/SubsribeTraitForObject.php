<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/20
 * Time: 11:30
 */
trait SubsribeTraitForObject
{
    public function getSubscribers()
    {
        return $this->make('subscribers',function(){
            return ModelsManager::createBuilder()
                ->from(['user'=>Users::class])
                ->leftJoin('Subscriber','user.id = sub.user_id','sub')
                ->where('sub.object_type = :class:',['class'=>get_class($this)])
                ->andWhere('sub.object_id = :id:',['id'=>$this->id])
                ->getQuery()->execute();
        });
    }
}