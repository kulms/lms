<?require("include/global_login.php");?>
<?if(($person["id"]==1 || $person["id"]==2 ||$person["id"]==6) && $person["admin"]==1){
	$info=str_replace("'","&#039;",$info);
	$address=str_replace("'","&#039;",$address);
	if($active!=1){
		$active=0;
	}
	if($admin!=1){
		$admin=0;
	}
	if($update=mysql_query("UPDATE users SET firstname='".$firstname."', surname='".$surname."', email='".$email."',password='".$password."',homepage='".$homepage."',picture='".$picture."',admin=$admin,address='".$address."',info='".$info."',active=$active WHERE id=$u_id;")){
		$ok=1;
	}else{
		$ok=0;
	}?>
	<html>
	<head>
		<title>Update user values</title>
		<link rel="STYLESHEET" type="text/css" href="main.css">
		<META HTTP-EQUIV="Refresh" CONTENT="1;URL=fulladmin.php">
	</head>
	<body bgcolor="#ffffff">
	<?if($ok==1){?>
	<p>&nbsp;</p>
		<p class="h5" align="center">User updated</p>
	<?}else{?>
		<p class="h5" align="center">Sorry, couldn't update user...</p>
	<?}?>
<?}else{?>
	<p class="h5" align="center"><b>You don't have access to this script!</b></p>
<?}?>
</body>
</html>
