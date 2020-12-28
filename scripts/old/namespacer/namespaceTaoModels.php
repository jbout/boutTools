<?php

require_once dirname(__FILE__).'/Namespacer.php';

$parms = $argv;
array_shift($parms);

if (count($parms) != 1) {
	echo 'Usage: '.__FILE__.' TAOROOT'.PHP_EOL;
} else {
    $root = rtrim(array_shift($parms), '/').'/';
	$namespacer = new Namespacer($root);
	
	$namespacer->namespaceify('tao_models_classes_', 'oat\\tao\\model\\');
	
	
	//$namespacer->simulateFile($root.'tao/includes/class.Bootstrap.php');
	//$namespacer->simulateFile($root.'tao/models/classes/menu/Action.php');
	//$namespacer->showAffectedFiles();
	
	$namespacer->execute();
	//rename($root.'tao/models/classes',                     $root.'tao/model');
	
}