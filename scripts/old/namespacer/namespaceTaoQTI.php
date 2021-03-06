<?php

require_once dirname(__FILE__).'/Namespacer.php';

$parms = $argv;
$script = array_shift($parms);

if (count($parms) != 1) {
	echo "Usage: ".$script." TAOROOT\n";
} else {
	$root =rtrim(array_shift($parms).'/').'/';
	$destination = '';//array_shift($parms);
	$renamer = new Namespacer($root, $destination);
	
	$renamer->namespaceify('taoQTI_models_classes_',       'oat\\taoQtiItem\\model\\');
	$renamer->namespaceify('taoQTI_models_classes_QTI',    'oat\\taoQtiItem\\model\\qti\\');	
	$renamer->namespaceify('taoQTI_actions_',              'oat\\taoQtiItem\\controller\\');
	$renamer->namespaceify('taoQTI_helpers_',              'oat\\taoQtiItem\\helpers\\');
	
	$renamer->simulate();
	/*
	$renamer->execute();
	
	rename($root.'taoQTI',                     $root.'taoQtiItem');
	rename($root.'taoQtiItem/actions',         $root.'taoQtiItem/controller');
	rename($root.'taoQtiItem/models/classes',  $root.'taoQtiItem/model');
	*/
}