<?php
error_reporting(E_ALL);
try {

    /*
     *加载composer
     */
    require '../vendor/autoload.php';
    /*
     * 获取环境设置变量
     */
    $dotEnv = new \Dotenv\Dotenv('../');
    $dotEnv->load();
    /**
     * Read the configuration
     */
    $config = include __DIR__ . "/../app/config/config.php";

    /**
     * Read auto-loader
     */
    include __DIR__ . "/../app/config/loader.php";

    /**
     * Read services
     */
    include __DIR__ . "/../app/config/services.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    /*
     *
     * 设置phalcon debugbar，需要下面两行
     * */
    $di['app'] = $application;
    (new Snowair\Debugbar\ServiceProvider('../app/config/debugbar.php'))->start();

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
