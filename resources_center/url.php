<? require("../include/global_login.php");
if($id==0){
	mysql_query("INSERT INTO resources_center (name,folder,refid,faculty,department,major,url,users,time) values('$name',0,$refid,'$fac','$dept','$major','$url',".$person["id"].",".time().");");
}else{
	mysql_query("UPDATE resources_center set url='$url' WHERE id=$id;");
}
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
