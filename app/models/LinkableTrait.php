<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/29
 * Time: 10:09
 */
trait LinkableTrait
{
    public function addLink($url)
    {
        /** @var myModel $this */
        $link = new Link();
        $link->save([
            'url'=>$url,
            'user_id'=>1,//@todo 将来替换成登录的用户id
            'linkable_type'=>get_class($this),
            'linkable_id'=>$this->id
        ]);
        $this->increaseCount('linkCount');
        return $this;
    }

    public function deleteLink(Link $link)
    {
        /** @var myModel $this */
        $link->delete();
        $this->decreaseCount('linkCount');
        return $this;
    }

    public function getLinks()
    {
        /** @var myModel $this */
        return $this->make('links',function(){
            /** @var myModel $this */
            return Link::query()
                ->where('linkable_type = :type:',['type'=>get_class($this)])
                ->andWhere('linkable_id = :id:',['id'=>$this->id])
                ->execute();
        });
    }

    public function beforeDeleteRemoveLinks()
    {
        $links = $this->getLinks();
        if($links->count()) $links->delete();
    }


}