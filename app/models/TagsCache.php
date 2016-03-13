<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/13
 * Time: 16:26
 */
class TagsCache extends myRedis
{
    //针对tags的缓冲函数
    protected function getTagsKey(Users $user = null)
    {
        if($user == null) $user = AuthFacade::getService();
        return $this->getPrefix().'users:'.$user->id.':tags';
    }
    public function isTagsExist(Users $user = null)
    {
        return $this->exist($this->getTagsKey($user));
    }
    public function setTags($tags,$user = null)
    {
        return $this->set($this->getTagsKey($user),json_encode($tags));
    }
    public function getTags($user = null)
    {
        return json_decode($this->get($this->getTagsKey($user)));
    }
    public function deleteTags($user = null)
    {
        return $this->delete($this->getTagsKey($user));
    }
}