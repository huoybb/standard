<?php
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
$eventsManager = new myEventManager();

//绑定dispatch的事件

$eventsManager->attach("dispatch:beforeDispatchLoop", function(Event $event, Dispatcher $dispatcher){
    //模型注入的功能，这里可以很方便的进行 model binding,这里基本上实现了Laravel中的模型绑定的功能了
    return RouterFacade::executeModelBinding($dispatcher);
});
$eventsManager->attach('dispatch:beforeExecuteRoute',function(Event $event, Dispatcher $dispatcher){
    //中间件形式的验证
    return RouterFacade::executeMiddleWareChecking(RequestFacade::getService(),ResponseFacade::getService(),$dispatcher);
});


//绑定自定义的事件
$eDomain = \Phalcon\Di::getDefault()->get('config')->application->eventPrefix;

$eventsManager->register($eDomain,[
    notificationHandler::class,
    searchLoghandler::class,
    authEventsHandler::class,
    cacheEventsHandler::class,
    tagsEventsHandler::class,//有这个必要吗？是否属于领域内的事情呢？
    taggablesEventsHandler::class,
]);

return $eventsManager;