<?
//
// common functions and variables for Maxlearn
//

//
// global database variables
$dbname = "vec";
$dbhost = "localhost";
$dbuser = "maxlearn";
$dbpass = "max";
$dbtype = "mysql";

$dsn = "$dbtype://$dbuser:$dbpass@$dbhost/$dbname";

$email_host="";
$path="vec";
$realpath="/home/maxlearn/vec";

$serverhost = $_SERVER["HTTP_HOST"];

?>