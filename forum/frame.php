<?

if ($action!=1) {

online_courses($session_id,$person["id"],$courses,time(),1);


//log activity to login_modules
mysql_query("INSERT INTO login_modules(users,modules,time) VALUES(".$person["id"].",$id,".time().");");

mysql_query("INSERT INTO forum_online(users,start_time,modules,status) VALUES(".$person["id"].",".time().",".$module.",1);");

mysql_query("INSERT INTO forum(users,time,info,modules,info_type) VALUES(".$person["id"].",".time().",'has logged in.',".$module.",1);");

}

?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">

<script>
 function exit() {

if( confirm("Exit Chat!! ?") ) {

     location.href = './index.php?a=exit&module=<? echo $module;?>&courses=<?echo $courses;?>'

          }else{

       location.href = './index.php?a=frame&module=<? echo $module;?>&courses=<?echo $courses;?>&action=1'


		  }



}
</script>
</head>

<frameset cols="*,180" frameborder="NO" border="0" framespacing="0" >
  <frameset rows="*,115" frameborder="NO" border="0" framespacing="0" onUnload="return exit();">
    <frame src="index.php?a=content&module=<?echo $module;?>" name="main" scrolling="yes" noresize>
    <frame src="index.php?a=compose&module=<?echo $module;?>&courses=<?echo $courses;?>" name="bottom" scrolling="yes" noresize>
  </frameset>
  <frame src="index.php?a=option&module=<?echo $module;?>&courses=<?echo $courses;?>" name="right" scrolling="yes" noresize >
</frameset>
<noframes><body>
</body></noframes>
</html>

<!--onUnload="main.location.href = './exit.php?module=<? echo $module;?>&courses=<?echo $courses;?>';"!-->