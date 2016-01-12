<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/29
 * Time: 10:09
 */
trait LinkableTrait
{
    public function addLink($url,$user = null)
    {
        /** @var myModel $this */
        $link = new Link();
        $user = $user ?: \Phalcon\Di::getDefault()->get('auth');
        $link->save([
            'url'=>$url,
            'user_id'=>$user->id,
            'linkable_type'=>get_class($this),
            'linkable_id'=>$this->id
        ]);
        if(property_exists($this,'linkCount')) $this->increaseCount('linkCount');
        return $this;
    }

    public function deleteLink(Link $link)
    {
        /** @var myModel $this */
        $link->delete();
        if(property_exists($this,'linkCount')) $this->decreaseCount('linkCount');
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