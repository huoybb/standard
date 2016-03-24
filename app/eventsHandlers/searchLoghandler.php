<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/24
 * Time: 11:35
 */
class searchLoghandler
{
    public function searchEvent($e,searchEvent $event)
    {
        $lastSearch = Searchlog::getLastSearch($event->user);
        if(null <> $lastSearch AND $lastSearch->keywords == $event->keywords) return $lastSearch->update();

        $data = [
            'user_id'=>AuthFacade::getID(),
            'keywords'=>$event->keywords,
            'extra'=>'in main database'
        ];
        Searchlog::saveNew($data);
    }

}