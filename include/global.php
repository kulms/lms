<?php
ini_set('include_path', '/data/httpd_course/html/pear');
require_once("../config/config.inc.php");

$conn=mysql_pconnect(DB_HOST,DB_USER,DB_PASSWORD);
mysql_select_db(DB_NAME);
mysql_query("SET NAMES TIS620");
//session_start();
$sql_theme=mysql_query("SELECT default_theme, site_logo FROM maxlearn_config;");
$theme_style=mysql_fetch_array($sql_theme);
$theme = "green";
$_SESSION['logo'] = $theme_style["site_logo"];
?>
