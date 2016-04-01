<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Security;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Cache\Frontend\Output as FrontOutput;


/**
 * helper function dd:die dump
 */
if(!function_exists('dd')){
    function dd($x){
        var_dump($x);die();
    }
}
/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();
    // Disable several levels，取消三级的模板渲染机制，这个将来也是可以利用一下的。
    $view->disableLevel(array(
        View::LEVEL_LAYOUT      => true,
        View::LEVEL_MAIN_LAYOUT => true
    ));

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {
            return include 'volt.php';
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        "charset" => $config->database->charset
    ));
});

//$di->set('viewCache',function(){
//    // Create an Output frontend. Cache the files for 2 days
//    $frontCache = new FrontOutput(
//        array(
//            "lifetime" => 172800
//        )
//    );

//    这里的主要问题是开启后，性能会突然变得非常慢，这个需要找出原因，还有就是与debugbar有冲突，会出现问题，需要解决
// Create the component that will cache from the "Output" to a "File" backend
// Set the cache file directory - it's important to keep the "/" at the end of
// the value for the folder
//    $cache = new Phalcon\Cache\Backend\Redis($frontCache, array(
//        'host' => 'localhost',
//        'port' => 6379,
////            'auth' => 'foobared',
//        'persistent' => false,
////            'statsKey' => 'standard:',
//    ));
//    return $cache;
//});
/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
},true);

/*
 * 设置security，这个可以用来加密密码以及产生token
 */
$di->set('security', function () {

    $security = new Security();

// Set the password hashing factor to 12 rounds
    $security->setWorkFactor(12);

    return $security;
}, true);
/*
 * 设置 cookies
 */
$di->set('cookies', function() {
    $cookies = new Cookies();
    $cookies->useEncryption(false);
    return $cookies;
},true);
//
$di->set('crypt', function() use($di) {
    $crypt = new \Phalcon\Crypt();
    //这里需要设置16位密码，或者24位、32位
    $crypt->setKey('myCryptKey024025');
    return $crypt;
},true);


/*
 * 设置 Flash
 */
$di->set('flash',function(){
    //使用bootstrap的css设置
    $flash = new Phalcon\Flash\Session([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
    return $flash;
});

/*
 * 设置路由
 * 以下的路由的设置好处是能够看清楚全部的路由信息！
 */
$di->set('router',function(){
    return include "routes.php";
},true);

/*
 * 设置dispatch， 类似router binding，将model注入到controller中，替换路由参数
 */
$di->set('dispatcher',function(){
    return include "dispatcher.php";
},true);

/*
 * 设置redis
 */
$di->set("redis", function() {
    return new myRedis();
},true);

$di->set('tagsCache',function(){
    return new TagsCache();
});


$di->set("carbon",function(){
    return new \Carbon\Carbon();
},true);

$di->set("myTools",function() use($config){
    $tools =  new myTools();
    $tools->setSiteName($config->siteName);
    return $tools;
},true);
/*
 * 为什么在volt中不能够直接引用呢？奇怪！！
 * 是因为使用静态调用导致的吗？
 */
$di->set("allTags",function(){
    return new Tags();
},true);

/*
 * 设置Event Manager
 */

$di->set('eventManager',function(){
    return include 'events.php';
},true);

/*
 * 身份验证的结果，这里给出当前登录的用户的身份，这里没有考虑guest的角色，将来可以考虑一下
 * 权限管理的设置需要找时间看看怎么做的！
 */
$di->set('auth',function() use($di){
    return Users::findFirst(SessionFacade::getAuthID());
},true);

$di->set('config',$config,true);
