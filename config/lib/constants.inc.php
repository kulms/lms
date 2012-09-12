<?php

if (!defined('AT_INCLUDE_PATH')) { exit; }

/***************
 * constants
 ******/
/* used for the collapse/expand as well as open/close */
define('MENU_CLOSE',        0);	/* also: DISABLE, COLLAPSE */
define('MENU_OPEN',         1); /* also: ENABLE,  EXPAND  */
define('OPEN',				1); /* also: ENABLE,  EXPAND  */
define('CLOSE',				0); /* also: ENABLE,  EXPAND  */

define('NONE',				0);
define('TOP',				1);
define('BOTTOM',			2);
define('BOTH',				3);

define('MENU_RIGHT',		0); /* the location of the menu */
define('MENU_LEFT',			1);

/* how many announcements listed */
define('NUM_ANNOUNCEMENTS', 10);

/* get the base url	*/
if (isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) == 'on') {
	$server_protocol = 'https://';
} else {
	$server_protocol = 'http://';
}

$dir_deep		= substr_count(AT_INCLUDE_PATH, '..');
$url_parts		= explode('/', $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
$_base_href		= array_slice($url_parts, 0, count($url_parts) - $dir_deep-1);
if ($_SERVER['SERVER_PORT'] != 80) {
	$_base_href[0] = $_base_href[0] . ':' . $_SERVER['SERVER_PORT'];
}
$_base_href		= $server_protocol . implode('/', $_base_href).'/';	

$_base_path = substr($_base_href, strlen($server_protocol . $_SERVER['HTTP_HOST']));

/* relative uri */
$_rel_url = '/'.implode('/', array_slice($url_parts, count($url_parts) - $dir_deep-1));



define('HELP',			0);
define('VERSION',		'2.0');
define('ONLINE_UPDATE', 3); /* update the user expiry every 3 min */

/* valid date format_types:						*/
/* @see ./include/lib/date_functions.inc.php	*/
define('AT_DATE_MYSQL_DATETIME',		1); /* YYYY-MM-DD HH:MM:SS	*/
define('AT_DATE_MYSQL_TIMESTAMP_14',	2); /* YYYYMMDDHHMMSS		*/
define('AT_DATE_UNIX_TIMESTAMP',		3); /* seconds since epoch	*/
define('AT_DATE_INDEX_VALUE',			4); /* index to the date arrays */

define('AT_ROLE_STUDENT',				0);
define('AT_ROLE_INSTRUCTOR',			1);

define('AT_KBYTE_SIZE',		         1024);

define('AT_DEFAULT_THEME',		        4); /* must match the theme_id in the theme_settings table */

$editable_file_types = array('txt', 'html', 'htm', 'xml', 'css', 'asc', 'csv');


?>