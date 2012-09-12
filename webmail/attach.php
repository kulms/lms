<?
require("../include/g.php");
$file=mysql_query("SELECT * from emailattach where id=$id;");

header("Content-type: ".mysql_result($file,0,"mime"));
header("Content-Disposition: attachment; filename=".mysql_result($file,0,"filename"));
header("Content-Description: PHP3 Generated Data" );

echo base64_decode(mysql_result($file,0,"cont"));
?>

