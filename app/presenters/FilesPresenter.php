<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:40
 */
class FilesPresenter extends myPresenter
{
    /**
     * @return string
     */
    public function repository()
    {
        $subRepo = $this->entity->getfileable();
        if($subRepo){
            return $subRepo->present()->repository;
        }

        return '标准：';
    }
    public function url()
    {
        $siteName = (new Link())->getSiteName($this->entity->url);
        return "<a href='{$this->entity->url}' target='_blank'>{$siteName}</a>";
    }

}