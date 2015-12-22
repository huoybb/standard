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
$compiler->addFunction('isset','isset');
$compiler->addFilter('basename','basename');
$compiler->addFilter('formatSizeUnits',function($size){ return 'myTools::formatSizeUnits('.$size.')';});
$compiler->addFilter('date',function($time){ return 'myTools::formatDate('.$time.')';});
$compiler->addFilter('cut',function($resolvedArgs,$exprArgs){ return 'myTools::cut('.$resolvedArgs.')';});//$exprArgs,这个变量的作用是什么呢？奇怪！

return $volt;