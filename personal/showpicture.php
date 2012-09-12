<?php  require("../include/global_login.php"); 
	    $users=mysql_query("SELECT * from users WHERE id=".$id);
?>
<html>
<head>
<title>:-: Show Picture :-:</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php  while($row=mysql_fetch_array($users))
		{   	?>
<table width=<?php echo $width; ?> height=<?php echo $height; ?> border="0" cellpadding="0" cellspacing="0"  align="center">
  <tr> 
    <td width=<?php echo $width; ?> height=<?php echo $height; ?>  align="center">
    <!--<img src="../files/preference/<?php echo $row["id"]."/original/".$row["picture"]; ?>" alt="Picture" style="cursor:hand" title="Click to close picture" onClick="window.close()">-->
        <img src="http://<?php echo $_SERVER["HTTP_HOST"];?>/preference/<?php echo $row["id"]."/original/".$row["picture"]; ?>" alt="Picture" style="cursor:hand" title="Click to close picture" onClick="window.close()">
    </td>
  </tr>
</table>
<?php     }    //  <div align="center"><b>.::</b> <a href="javascript:window.close()">Close</a><b>::.</b></div>  -->
?>
</body>
</html>