<?php

require_once dirname(__FILE__).'/Namespacer.php';

$parms = $argv;
array_shift($parms);

if (count($parms) != 1) {
	echo "Usage: renameTaoQTI.php TAOROOT\n";
} else {
	$root =rtrim(array_shift($parms).'/').'/';
	$destination = '';//array_shift($parms);
	$renamer = new Namespacer($root, $destination);
	
	$renamer->namespaceify('ltiDeliveryProvider_models_classes_',       'oat\\ltiDeliveryProvider\\model\\');
	$renamer->namespaceify('ltiDeliveryProvider_actions_',             'oat\\ltiDeliveryProvider\\controller\\');
	$renamer->namespaceify('ltiDeliveryProvider_helpers_',              'oat\\ltiDeliveryProvider\\helpers\\');
	
	$renamer->showAffectedFiles();
	$renamer->execute();
	/*
	*/
}
