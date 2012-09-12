<?
session_start();
require("../include/global_login.php");




mysql_query("INSERT INTO forum(users,time,info,modules,info_type) VALUES(".$person["id"].",".time().",'has logged Out.',".$module.",1);");
	


$sql =  "UPDATE forum_online SET status = 0,
										end_time = ".time()."  
										 WHERE users = ".$person["id"]." and modules = ".$module." and status = 1";
                        
					$result =	mysql_query($sql);
	
					
if ($result) {

print( "<script language=javascript>alert('Exit Chat Success!!');location.href='index.php?id=$module&courses=$courses'</script>");	

}

//location.href=' index.php?id=$module&courses=$courses';

//else{
//print "<div align=\"center\"><br><br><b>Exit Chat</b></div>";
//print "<meta http-equiv=\"refresh\" content=\"3;URL=index.php?id=$module&courses=$courses\">";
//}
?>





