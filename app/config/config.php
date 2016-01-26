<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => $_ENV['Database_adapter'],
        'host'        => $_ENV['Database_host'],
        'username'    => $_ENV['Database_username'],
        'password'    => $_ENV['Database_password'],
        'dbname'      => $_ENV['Database_dbname'],
        'charset'     => $_ENV['Database_charset'],
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'formDir'        => __DIR__ . '/../../app/forms/',
        'middlewaresDir' => __DIR__ . '/../../app/middlewares/',
        'events'         => __DIR__ . '/../../app/events/',
        'baseUri'        => '/',
    ),
    'siteName' =>$_ENV['SiteName'],
));
