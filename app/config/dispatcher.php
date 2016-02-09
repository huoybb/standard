<?php

$eventsManager = new \Phalcon\Events\Manager();
$eventsManager->attach("dispatch:beforeDispatchLoop", function($event, \Phalcon\Mvc\Dispatcher $dispatcher){
    //模型注入的功能，这里可以很方便的进行 model binding,这里基本上实现了Laravel中的模型绑定的功能了
    try{
        $reflection = new ReflectionMethod($dispatcher->getControllerClass(), $dispatcher->getActiveMethod());
        $actionParams = [];
        foreach($reflection->getParameters() as $parameter){

            $objectId = $dispatcher->getParam($parameter->name);
            if(null == $objectId && $parameter->isDefaultValueAvailable()) $objectId = $parameter->getDefaultValue();

            if($parameter->getClass()){
                $className = RouterFacade::getProvider($parameter->getClass()->name);

                if($objectId){
                    if(is_subclass_of($className,\Phalcon\Mvc\Model::class)){
                        /** @var \Phalcon\Mvc\Model $className */
                        $actionParams[$parameter->name] = $className::findFirst($objectId);
                    }else{
                        $actionParams[$parameter->name] = new $className($objectId);
                    }

                }else{
                    $actionParams[$parameter->name] = new $className;
                }
            }else{
                $actionParams[$parameter->name] = $objectId;
            }
        }

        if(count($actionParams)){
            $dispatcher->setParams($actionParams);
        }


    } catch(\Phalcon\Exception $e) {
        var_dump($e);
        die();
    }

});

$dispatcher = new \Phalcon\Mvc\Dispatcher();
$dispatcher->setEventsManager($eventsManager);
return $dispatcher;