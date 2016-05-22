<?php

use Phalcon\Mvc\Dispatcher;

$dispatcher = new Dispatcher();
$dispatcher->setEventsManager(EventFacade::getService());
return $dispatcher;