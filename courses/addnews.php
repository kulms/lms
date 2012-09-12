<?php   require("../include/global_login.php"); 
				$check=mysql_query("SELECT c.name,c.info,c.fullname,c.section from wp,courses c  WHERE
				wp.courses=$courses AND wp.users=".$person["id"]." AND c.id=wp.courses;");
				
				$news=mysql_query("SELECT   nc.txt_news FROM news_courses nc, courses c  
				WHERE  c.id=nc.courses  AND  nc.courses=$courses;");
				
				if(mysql_num_rows($check)==0){
						echo "YOU DO NOT HAVE ACCESS TO THIS COURSE!!!!!";
						exit();
				}else{  $course=mysql_fetch_array($check);	}
?>
<html>
<head>
		<title>:: Course news ::</title>
		<script language="javascript">
		</script>
		<link rel="STYLESHEET" type="text/css" href="../../main.css">
		<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
		<center>
			<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
				background="../images/headerbg.gif" height="53">
				  <tr><td class="menu" align="center">
						<b><? echo $course["name"]?>  <? if ($course["section"] !="") {  ?>
						<font color="#ff33ff">[ </font>
						<font color="#99ff99"> หมู่ <? echo $course["section"] ?> </font><font color="#ff33ff">]</font><? }?>
						<br><? echo $course["fullname"]?></b>
				</td></tr>
			</table>
		</center>
		
<hr width="50%" align="center">

<form name="form1" method="post" action="../../activity.php">
    <table width="480" border="0" align="center">
		<tr> 
			  <td><div align="center"><b>ประกาศ / News</b> </div></td>
		</tr>
		<tr> 
			  <td>เนื้อความประกาศ :</td>
		</tr>
		<tr> 
			  <td> <div align="center"> 
					  <textarea name="textarea" cols="80" rows="10" wrap="PHYSICAL">
							  <?php  echo ($row["txt_news"]); ?>
					  </textarea></div>
			  </td>
		</tr>
		<tr>
			  <td><input type="submit" name="Submit" value="Submit">
        <input type="reset" name="Submit2" value="Reset"> </td>
		</tr>
   </table>
</form>

<p>&nbsp; </p>

</body>
</html>