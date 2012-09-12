<?
session_start();
require("../include/global_login.php");

 ?>
 
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">

<?
/*
$sql =  mysql_query("select * from resource_center_usage where  users = ".$person["id"]." and status = 1");
  
  $row =  mysql_num_rows($sql);
 
 						
 if ($row!=0) {
 
$opened=1;
 
  $result = mysql_fetch_array($sql); 
  */
 
 ?>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
var ms = 0;
var state = 0;
var utime = 0;
function startstop() {
if (state == 0) {
state = 1;
then = new Date();
then.setTime(then.getTime() - ms);
} else {
state = 0;
now = new Date();
ms = now.getTime() - then.getTime();
//document.stpw.time.value = ms/1000;
   }
   if((ms/1000) > 0){  
   utime = ms/1000;
    //alert(utime); 
   document.location.href="counter.php?utime="+utime+"&id=<? echo $id?>";  
   }
   
}
function swreset() {
state = 0;
ms = 0;
document.stpw.time.value = ms;
}
function display() {
setTimeout("display();", 50);
if (state == 1)  {now = new Date();
ms = now.getTime() - then.getTime();
document.stpw.time.value = ms;
   }
}
// End -->
</SCRIPT>
<?
 ?>
</head>
<body onLoad="startstop()" onUnload="startstop()">
<?
$sql =  "INSERT INTO resource_center_using (resource_center_id, users, total_time) VALUES ($id, ".$person["id"].", $time);";
mysql_query($sql);
echo	"<iframe src=\"../files/resources_center_files/$id/$index_name\" width='1024' height='720' frameborder=0 marginheight=0 marginwidth=0 scrolling=yes></iframe>";
?>
<!--<iframe src="content.php?id=<? echo $id;?>&index_name=<? echo $index_name;?>&users=<? echo $person["id"];?>" width=1012 height=740 frameborder=0 marginheight=0 marginwidth=0 scrolling=yes></iframe>-->
</body>
</html>
