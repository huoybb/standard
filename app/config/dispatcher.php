<?php

$eventsManager = new \Phalcon\Events\Manager();
$eventsManager->attach("dispatch:beforeDispatchLoop", function($event, \Phalcon\Mvc\Dispatcher $dispatcher){
    //模型注入的功能，这里可以很方便的进行 model binding,这里基本上实现了Laravel中的模型绑定的功能了
    $controllerName = $dispatcher->getControllerClass();
    $actionName = $dispatcher->getActiveMethod();
    try{
        $reflection = new ReflectionMethod($controllerName,$actionName);
        $actionParams = [];
        foreach($reflection->getParameters() as $parameter){
//                var_dump($parameter->getClass());die();
            if($parameter->getClass()){
                $className = $parameter->getClass()->name;
                $objectId = $dispatcher->getParam($parameter->name);

                if($objectId){
                    if(is_subclass_of($className,\Phalcon\Mvc\Model::class)){
                        $actionParams[$parameter->name] = $className::findFirst($objectId);

                    }else{
                        $actionParams[$parameter->name] = new $className($objectId);
                    }
                }else{
                    $actionParams[$parameter->name] = new $className;
                }
                //如果没有找到相关的资源，应该抛出一个错误才对！
                if(!$actionParams[$parameter->name]) dd('没有找到相关资源');

            }else{
                //如果参数是普通参数的话如何处置？
                //如果存在路由参数，则赋值，否则给一个null结果
                $value = $dispatcher->getParam($parameter->name);
                if(null == $value and $parameter->isDefaultValueAvailable()) $value = $parameter->getDefaultValue();
                $actionParams[$parameter->name] = $value;
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