<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->presenters,
        $config->application->pluginsDir,
        $config->application->formDir,
        $config->application->middlewaresDir,
        $config->application->events,
        $config->application->handlers,
        $config->application->facades,
    )
)->register();
