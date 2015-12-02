<?php
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

/** @var Phalcon\Mvc\View $view */
/** @var Phalcon\DI\FactoryDefault $di */
$volt = new VoltEngine($view, $di);

$volt->setOptions(array(
'compiledPath' => $config->application->cacheDir,
'compiledSeparator' => '_'
));

$compiler = $volt->getCompiler();
$compiler->addFunction('get_class','get_class');
$compiler->addFilter('basename','basename');
$compiler->addFilter('formatSizeUnits',function($size){ return 'myTools::formatSizeUnits('.$size.')';});
$compiler->addFilter('cut',function($string){ return 'myTools::cut('.$string.')';});

return $volt;