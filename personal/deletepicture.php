<?php  require("../include/global_login.php");
	$filepath = "/data/httpd_course/files/";
   // $checkfile=mysql_query("SELECT newuploadfilename FROM syllabus where courses=$courses;");	
	 $users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
	 $pictname = explode("/",mysql_result($users,0,"picture"));
	 //$workdir=$realpath."/files/preference/".$person["id"]."/";
	 $workdir=$filepath."/preference/".$person["id"]."/";
	 if($pictname <> "")
	 {	// delete files
		 if(file_exists($workdir.$pictname))
			 unlink($workdir.$pictname);
		 mysql_query("UPDATE users SET picture='' WHERE id=".$person["id"]);
	  }else{	
			print( "<script language=javascript> alert(\"Completely Delete picture file.\"); </script>");
			print( "<script language=javascript> document.location='prefs.php?id=".$person["id"]."'; </script>");
		   }					
?>
<html>
<head>
<body>
<meta http-equiv="refresh" content="0;url=prefs.php">
</body>
</head>
</html>