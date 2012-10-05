<?require("../include/global_login.php");

$check=mysql_query("SELECT max(time) As mTime FROM forum_ori WHERE modules=$module;");
if(mysql_num_rows($check)!=0){
	$moduleud=mysql_result($check,0,"mTime");
}else{
	$moduleud=time();
}
?>
<html><head>
<meta http-equiv="refresh" content="5;URL=ud.php?module=<?echo $module;?>">
<script LANGUAGE="JavaScript">
parent.check("<?echo $moduleud;?>");
</script>
</head>
<body bgcolor="#ffffff">
&nbsp;
</body>
</html>
<?mysql_close();?>