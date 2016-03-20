<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => getenv('Database_adapter')?:'mysql',
        'host'        => getenv('Database_host') ?: 'localhost',
        'username'    => getenv('Database_username') ?: 'root',
        'password'    => getenv('Database_password') ?: '',
        'dbname'      => getenv('Database_dbname') ?: 'standards',
        'charset'     => getenv('Database_charset') ?: 'utf8',
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
        'handlers'         => __DIR__ . '/../../app/handlers/',
        'facades'         => __DIR__ . '/../../app/facades/',
        'webParsers'         => __DIR__ . '/../../app/webParsers/',
        'baseUri'        => '/',
    ),
    'siteName' =>getenv('SiteName')?:(isset($_ENV['SiteName'])?$_ENV['SiteName']:null),
));
