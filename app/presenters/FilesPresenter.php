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
    public function title()
    {
        $subRepo = $this->entity->getfileable();
        if($subRepo){
            return $subRepo->present()->title;
        }

        return '标准：'.$this->entity->title;
    }
    public function url()
    {
        $siteName = (new Link())->getSiteName($this->entity->url);
        return "<a href='{$this->entity->url}' target='_blank'>{$siteName}</a>";
    }

}