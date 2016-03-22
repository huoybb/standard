<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/18
 * Time: 7:14
 */
class searchEventHandler
{
    public function main($event,\Phalcon\Mvc\Controller $controller,$search)
    {
        $lastSearch = Searchlog::getLastSearch(AuthFacade::getService());
        if(null <> $lastSearch AND $lastSearch->keywords == $search) return $lastSearch->update();

        $data = [
            'user_id'=>AuthFacade::getID(),
            'keywords'=>$search,
            'extra'=>'in main database'
        ];
        Searchlog::saveNew($data);

    }
    public function sub($event,\Phalcon\Mvc\Controller $controller,array $data)
    {
        $lastSearch = Searchlog::getLastSearch(AuthFacade::getService());
        if($lastSearch->keywords == $data['search']) return $lastSearch->update();
        $data = [
            'user_id'=>AuthFacade::getID(),
            'keywords'=>$data['search'],
            'extra'=>"in {$data['repository']} sub database"
        ];
        Searchlog::saveNew($data);
    }

}