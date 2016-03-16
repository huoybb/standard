<?php
require __DIR__ .'/../../vendor/autoload.php';
$dotEnv = new \Dotenv\Dotenv(__DIR__ .'/../../');
$dotEnv->load();

$config = include __DIR__ . "/config.php";
include __DIR__ . "/loader.php";
$di = new \Phalcon\DI\FactoryDefault();
include __DIR__ . "/services.php";
return new \Phalcon\Mvc\Application($di);
?>