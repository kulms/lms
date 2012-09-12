<?require("../include/global_login.php");
if($id!=""){
	$SQLStmt = "SELECT p.*,u.firstname,u.surname,u.email FROM peer p, users u WHERE p.id=$id AND u.id =p.users;";  
	$oRS = mysql_query($SQLStmt);
	if(mysql_num_rows($oRS)!=0){
  		while($p_row=mysql_fetch_array($oRS)){
			$memo = $p_row["memo"];
			$words = $p_row["words"];
			$firstname = $p_row["firstname"];
			$surname = $p_row["surname"];
			$title = $p_row["title"];
			$memo = nl2br($memo);
			$email=$p_row["email"];
		}//end while
	}// End If
}//End If
?>
<html>
<head>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff" topmargin="0">
<a href="javascript:history.go(-1);" class="main">Back</a>
<table cellspacing="0" cellpadding="5" width="100%">
<tr bgcolor="#808080">
	<td class="main"><b>Author</b></td>
	<td class="main"><b>Title</b></td>
	<td class="main"><b>Word count</b></td>
</tr>
<tr>
	<td class="main"><b><a href="mailto:<?echo $email ?>"><?echo $firstname ?><? if($surname!=""){ ?>&nbsp;<?echo $surname ?><?}?></b></a></td>
	<td class="main"><b><i><?echo $title ?></i></b></td>
	<td class="main" class="main"><?echo $words ?> words</td>
</tr>
<tr>
	<td colspan="3" class="main"><p>&nbsp;<br></p><?echo $memo ?></td>
</tr>

</table>
<a href="Javascript:history.go(-1)"><font class="main">Back</font></a>
</body>
</html>