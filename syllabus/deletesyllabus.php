<?
	require("../include/global_login.php");
    $checkfile=mysql_query("SELECT newuploadfilename FROM syllabus where courses=".$_GET['courses'].";");
	if(file_exists($path."/".$checkfile["newuploadfilename"]))
	{	
		unlink($path."/".$checkfile["newuploadfilename"]);		
	}
	mysql_query("UPDATE syllabus SET newuploadfilename='', syllabus_upload='' WHERE courses=".$_GET['courses'].";");
	print( "<script language=javascript> alert(\"Completely Delete syllabus file.\"); </script>");
	print( "<script language=javascript> document.location='index.php?courses=$courses'; </script>");								
?>