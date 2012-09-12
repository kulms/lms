<? require("../include/global_login.php");

$newfile_name=strtolower($file_name);
$newfile_name=strtr($newfile_name,"дец? ","aaoq_");
$newfile_name=str_replace(".php",".html",$newfile_name);
$newfile_name=str_replace(".cgi",".html",$newfile_name);
$newfile_name=str_replace(".pl",".html",$newfile_name);
$newfile_name=str_replace(".phtml",".html",$newfile_name);
$newfile_name=str_replace(".shtml",".html",$newfile_name);
$newfile_name=str_replace("'","&#039;",$newfile_name);

if($id==0){
	mysql_query("INSERT INTO resources_center (name,folder,refid,faculty,department,major,file,users,time) 
				 VALUES('".str_replace("'","&#039;",$name)."',0,$refid,'$fac','$dept','$major','$newfile_name',".$person["id"].",".time().");");
	$id=mysql_insert_id();
}else{
	mysql_query("UPDATE resources_center set file='$newfile_name' WHERE id=$id;");
}
exec("rm -R -f $realpath/files/resources_center_files/$id");
$allpath=$realpath."/files/resources_center_files/".$id;
mkdir($allpath,0777);
chmod($allpath,0777);
copy($file,$allpath."/".$newfile_name);

//mysql_query("UPDATE modules set updated=".time().", updated_users=".$person["id"]." WHERE id=$modules;");

//header("Status: 302 Moved Temporarily");
//header("Location: show_res.php?fac=$fac&dept=$dept&major=$major");
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body >
<? 
if ($chk==0) { ?>
	<meta http-equiv="refresh" content="0;url=show_res.php?fac=-1&dept=-1&major=no"><?
} elseif ($chk==1) { ?>
		<meta http-equiv="refresh" content="0;url=show_res.php?fac=<? echo $fac?>&dept=-1&major=no"><? 
	} elseif ($chk==2) { ?>
			<meta http-equiv="refresh" content="0;url=show_res.php?fac=<? echo $fac?>&dept=<? echo $dept?>&major=no"><?
		} elseif ($chk==3) { ?>
				<meta http-equiv="refresh" content="0;url=show_res.php?fac=<? echo $fac?>&dept=<? echo $dept?>&major=<? echo $major?>"> <?				
			} 
?>
</body>
</html>
