<?
session_start();
$session_id = session_id();
require("../include/global_login.php");
require("../include/online.php");
online_courses($session_id,$person["id"],$courses,time(),1);

$check=mysql_query("SELECT max(time) AS mTime FROM forum_ori WHERE modules=$id;");
if(mysql_num_rows($check)!=0){
	$moduleud=mysql_result($check,0,"mTime");
}else{
	$moduleud=time();
}
	//log activity to login_modules
mysql_query("INSERT INTO login_modules(users,modules,time) VALUES(".$person["id"].",$id,".time().");");
?>

<html><head>
<title>Forum</title>
<script LANGUAGE="JavaScript">
	<!--
	var datumnu="<?echo $moduleud;?>";
	var aktiv=1;
	function check(datum){
		if(datumnu!=datum){
			if(aktiv==1){
//				frames["head_2"].location.href="show.php?module=<?echo $id;?>";
				frames["head_2"].location.reload();
				}
		}
		datumnu=datum;
	}
	// - End of JavaScript - -->
</script>
</head>
	<frameset rows="50,0,*" border="0"> 
		<frame src="menu.php?module=<?echo $id;?>" name="meny2" scrolling="no" marginwidth="2" marginheight="2" noresize>
		<frame src="ud.php?module=<?echo $id;?>" name="ud" scrolling="no" marginwidth="0" marginheight="0" noresize>
		<frame src="show.php?module=<?echo $id;?>" name="head_2" marginwidth="2" marginheight="2">
	</frameset><noframes></noframes>
</html>
<?mysql_close();?>
