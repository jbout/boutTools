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
	
	$renamer->namespaceify('core_kernel_persistence_smoothsql_',   'oat\\generis\\altsmooth\\');
	
	$renamer->showAffectedFiles();
	$renamer->simulate();
	/*
	$renamer->execute();
	
	rename($root.'taoQTI',                     $root.'taoQtiItem');
	rename($root.'taoQtiItem/actions',         $root.'taoQtiItem/controller');
	rename($root.'taoQtiItem/models/classes',  $root.'taoQtiItem/model');
	*/
}
