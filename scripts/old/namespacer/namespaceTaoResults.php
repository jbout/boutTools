<?php

// rename to ontoResultStorage

require_once dirname(__FILE__).'/Namespacer.php';

$parms = $argv;
$script = array_shift($parms);

if (count($parms) != 1) {
	echo "Usage: ".$script." TAOROOT\n";
} else {
	$root =rtrim(array_shift($parms).'/').'/';
	$destination = '';//array_shift($parms);
	$renamer = new Namespacer($root, $destination);
	
	$renamer->namespaceify('taoResults_models_classes_',   'oat\\taoOutcomeUi\\model\\');
	$renamer->namespaceify('taoResults_actions_',          'oat\\taoOutcomeUi\\controller\\');
	$renamer->namespaceify('taoResults_helpers_',          'oat\\taoOutcomeUi\\helper\\');
	
	$renamer->execute();
	//$renamer->showAffectedFiles();
	//$renamer->simulate();
	/*
	$renamer->execute();
	
	rename($root.'taoQTI',                     $root.'taoQtiItem');
	rename($root.'taoQtiItem/actions',         $root.'taoQtiItem/controller');
	rename($root.'taoQtiItem/models/classes',  $root.'taoQtiItem/model');
	*/
}