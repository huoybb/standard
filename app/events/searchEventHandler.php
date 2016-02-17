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
        $data = [
            'user'=>AuthFacade::getID(),
            'action'=>'search',
            'paras'=>$search,
            'extra'=>'in main database'
        ];
        //处理data，保存到log中
//        dd($data);
    }
    public function sub($event,\Phalcon\Mvc\Controller $controller,array $data)
    {
        $data = [
            'user'=>AuthFacade::getID(),
            'action'=>'search',
            'paras'=>$data['search'],
            'extra'=>"in {$data['repository']} sub database"
        ];
        //处理data，保存到log中
//        dd($data);
    }

}