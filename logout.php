<?
if(!isset($PHP_AUTH_USER))
{
Header ("WWW-Authenticate: Basic realm=\"Course\"");
$PHP_AUTH_USER.="logout";
exit;
}else{
Header ("WWW-Authenticate: Basic realm=\"Course\"");
Header("Expires: 0");
Header("Cache-Control: no-cache, must-revalidate");
Header("Pragma: no-cache");
$PHP_AUTH_USER="logout";
$PHP_AUTH_PW="logout";
echo " You logout already<p>";
exit;
}
?>
