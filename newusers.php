<?require("include/global_login.php");
if($insert==0){
?>
	<html>
	<head>
	<title>Insert users</title>
	<link rel="STYLESHEET" type="text/css" href="main.css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	<body bgcolor="#CCCCCC" onLoad="Javascript:document.newusers.firstname.focus();">
	<p>&nbsp;</p>
	<form method="post" action="newusers.php" name="newusers">
	  <table width="75%" border="0">
	  	<tr>
	     <td width="13%">&nbsp;</td>
	      <td width="13%">&nbsp;</td>
	      <td class="h3" width="84%">Add new User</td>
	      <td width="3%">&nbsp;</td>
	    </tr>
	    <tr> 
	      <td width="13%">&nbsp;</td>
	      <td class="main" width="13%">Firstname </td>
	      <td width="84%"> 
	        <input type="text" name="firstname">
	      </td>
	      <td width="3%">&nbsp;</td>
	    </tr>
	    <tr> 
	      <td width="13%">&nbsp;</td>
	      <td class="main" width="13%">Surname</td>
	      <td width="84%"> 
	        <input type="text" name="surname">
	      </td>
	      <td width="3%">&nbsp;</td>
	    </tr>
	    <tr> 
	      <td width="13%">&nbsp;</td>
	      <td class="main" width="13%">Login</td>
	      <td width="84%"> 
	        <input type="text" name="login">
	      </td>
	      <td width="3%">&nbsp;</td>
	    </tr>
	    <tr> 
	      <td width="13%">&nbsp;</td>
	      <td class="main" width="13%">Password</td>
	      <td width="84%"> 
	        <input type="text" name="password">
	      </td>
	      <td width="3%">&nbsp;</td>
	    </tr>
	    <tr> 
	      <td width="13%">&nbsp;</td>
	      <td class="main" width="13%">eMail</td>
	      <td width="84%"> 
	        <input type="text" name="email">
	      </td>
	      <td width="3%">&nbsp;</td>
	    </tr>
	    <tr>
	      <td width="13%">&nbsp;</td>
	      <td class="main" width="13%">Admin</td>
	      <td width="84%">
	        <input value="1" type="checkbox" name="admin" value="checkbox">
	      </td>
	      <td width="3%">&nbsp;</td>
	    </tr>
	    <tr> 
	      <td width="13%">&nbsp;</td>
	      <td width="13%">&nbsp;</td>
	      <td width="84%">
		  	<input type="hidden" name="insert" value="1">
	        <input type="submit" name="Submit" value="S u b m i t">
	        <input type="reset" name="Submit2" value="C l e a r">
	      </td>
	      <td width="3%">&nbsp;</td>
	    </tr>
	  </table>
	  <p>&nbsp; </p>
	</form>
	</body>
	</html>
<?
}else{
	if($admin==""){
		$admin=0;
	}
	$users=mysql_query("SELECT id from users WHERE login='".$login."';");
	if($check=mysql_fetch_array($users)){	// if user exists
		?>
		<html>
		<head>
			<link rel="STYLESHEET" type="text/css" href="main.css">
		</head>
		<body bgcolor="#CCCCCC" onLoad="Javascript:document.newusers.again.focus();">
		<p>&nbsp;</p>
		<div class="h3" align="center">Sorry, user already exists.</div>
		<p>
		<div class="main" align="center">Couldn't create account.
		<form name="newusers">
			<input name="again" type="button" value="Try again" onClick="Javascript:window.location='newusers.php?insert=0';">
		</form>
		</div>

		</body>
		</html>
		<?
	}else{
		$sql="INSERT INTO users(firstname,surname,login,password,email,admin,active) VALUES('".str_replace("'","&#039;",$firstname)."','".str_replace("'","&#039;",$surname)."','".str_replace("'","&#039;",$login)."','".str_replace("'","&#039;",$password)."','".str_replace("'","&#039;",$email)."',$admin,1);";
	//	echo $sql;
		if(mysql_query($sql)){
		?>
			<html>
			<head>
			<title>Insert users</title>
			<link rel="STYLESHEET" type="text/css" href="main.css">
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			</head>
			<body bgcolor="#CCCCCC" onLoad="Javascript:document.newusers.again.focus();">
			<div align="center" class="main">OK, inserted <?echo $firstname."&nbsp;".$surname?>
			<form name="newusers">
				<input name="again" type="button" value="New User" onClick="Javascript:window.location='newusers.php?insert=0';">
			</form>
			</div>
		<?}else{?>
			Sorry, couldn't insert user...
	<?
		}
	}
}?>
