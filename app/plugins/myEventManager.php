<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/11
 * Time: 20:20
 * 提供一个全局的事件处理管理器
 */
class myEventManager extends \Phalcon\Events\Manager
{
    // $this->listen('auth:login','authEventHandler::login');
    /**
     * @param $eventName
     * @param $handlerAction
     */
    public function listen($eventName, $handlerAction)
    {
        $this->attach($eventName,function($event,$object=null,$data=null) use($handlerAction){
            if (preg_match('/(.+)::(.+)/m', $handlerAction, $regs)) {
                $handlerName = $regs[1];
                $action = $regs[2];
                $handler = new $handlerName;
                $handler->$action($event,$object,$data);
            }
        });
    }
    public function register($eventNamePlus,array $handlerClassArray)
    {
            foreach($handlerClassArray as $handler){
                $this->attach($eventNamePlus,new $handler);
            }
    }


}