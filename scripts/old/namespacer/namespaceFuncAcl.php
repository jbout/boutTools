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
	
	$renamer->namespaceify('funcAcl_models_classes_',       'oat\\funcAcl\\model\\');
	$renamer->namespaceify('funcAcl_actions_',              'oat\\funcAcl\\controller\\');
	$renamer->namespaceify('funcAcl_helpers_',              'oat\\funcAcl\\helpers\\');
	
	$renamer->showAffectedFiles();
	$renamer->simulateFile('/home/bout/code/php/taoTrunk/funcAcl/actions/class.Admin.php');
	/*
	$renamer->execute();
	
	rename($root.'funcAcl/models/classes',  $root.'funcAcl/model');
	*/
}