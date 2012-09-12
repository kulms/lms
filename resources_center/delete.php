<? require("../include/global_login.php");
mysql_query("DELETE FROM resources_center WHERE id=$id;");
//exec("rm -R -f $realpath/resources/files/$id");
exec("rm -R -f $realpath/files/resources_center_files/$id");
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
