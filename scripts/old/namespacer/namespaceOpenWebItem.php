<?php

require_once dirname(__FILE__).'/Namespacer.php';

$parms = $argv;
array_shift($parms);

if (count($parms) != 1) {
	echo 'Usage: '.__FILE__.' TAOROOT'.PHP_EOL;
} else {
	$root =rtrim(array_shift($parms).'/').'/';
	$namespacer = new Namespacer($root);
	
	$namespacer->namespaceify('taoOpenWebItem_model',         'oat\\taoOpenWebItem\\model\\');
	$namespacer->namespaceify('taoOpenWebItem_actions_',      'oat\\taoOpenWebItem\\controller\\');
	
	//$namespacer->showAffectedFiles();
	$namespacer->execute();
}