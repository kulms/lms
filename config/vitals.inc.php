<?php
if (!defined('AT_INCLUDE_PATH')) { exit; }

define('AT_DEVEL', 0);
define('AT_DEVEL_TRANSLATE', 0);


/********************************************/
/* timing stuff								*/
if (defined('AT_DEVEL') && AT_DEVEL) {
	$microtime = microtime();
	$microsecs = substr($microtime, 2, 8);
	$secs = substr($microtime, 11);
	$startTime = "$secs.$microsecs";
}
/********************************************/

/**** 0. start system configuration options block ****/
	error_reporting(0);
		include(AT_INCLUDE_PATH.'config.inc.php');		
	error_reporting(E_ALL ^ E_NOTICE);

	if (!defined('AT_INSTALL') || !AT_INSTALL) {
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Pragma: no-cache');

		$relative_path = substr(AT_INCLUDE_PATH, 0, -strlen('../config/'));
		header('Location: ' . $relative_path . '../install/not_installed.php');
		exit;
	}
/*** end system config block ****/

?>