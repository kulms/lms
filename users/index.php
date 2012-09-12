<?php		 
	require("../include/global_login.php");
	$ut = mysql_query("SELECT id,nametype FROM users_type ORDER BY id");							 
	$ut2 = mysql_query("SELECT id,nametype FROM users_type ORDER BY id");							 
?>
<html>
<head>
<title>Users</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body >
<a name="top"></a> 
<table width="600" border="0" align="center">
  <tr> 
    <td height="33"  class="bluenav"><div align="center"> <b><font color="#FFFFFF">.:: 
        Users of Maxlearn ::.</font></b></div></td>
  </tr>  
</table>

<br>
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="5"></td>
  </tr>
  <tr> 
    <td height="35" colspan="5"><div align="right"><font color="#666600"><b> [ 
        <a href="add_user.php">Add User</a> ]</b></font></div></td>
  </tr>
  <tr> 
    <td height="35" colspan="5"><div align="center">
	<? while ($row_ut2=mysql_fetch_array($ut2)){?>
			<a href="#<? echo $row_ut2["nametype"];?>">[ <? echo $row_ut2["nametype"];?> ]</a>
	<? }?>
	</div></td>
  </tr>
  <? 
  	while ($row_ut=mysql_fetch_array($ut))	 {
    ?>
  <tr> 
    <td colspan="5"><b>ประเภทผู้ใช้ : 
      <? 
	  echo $row_ut["nametype"];  
	  $u = mysql_query("SELECT id,login,firstname,surname FROM users WHERE category=".$row_ut["id"]." ORDER BY id;");
	  ?>
      </b> <a name="<? echo $row_ut["nametype"];?>"></a> 
    </td>
  </tr>
  <tr> 
    <td width="5%" class="bluenav"><div align="center"><font color="#FFFFFF"><b>No.</b></font></div></td>
    <td width="25%" class="bluenav"><div align="center"><font color="#FFFFFF"><b> 
        Login</b></font></div></td>
    <td width="25%" class="bluenav"><div align="center"><font color="#FFFFFF"><b> 
        FirstName</b></font></div></td>
    <td width="20%" class="bluenav"><div align="center"><font color="#FFFFFF"><b> 
        SurName </b></font></div></td>
    <td width="5%" class="bluenav"><div align="center"><font color="#FFFFFF"><b>Action</b></font></div></td>
  </tr>
  <?
  $num = 1;
   $bgcolor = "#d4e2ed";
  
  while ($row_u = mysql_fetch_array($u)) {
  ?>
  <tr> 
    <td bgcolor="<? if (($num%2)==0) echo "$bgcolor" ?>"><div align="center"><? echo $num;?></div></td>
    <td bgcolor="<? if (($num%2)==0) echo "$bgcolor" ?>"><? echo  $row_u["login"]; ?></td>
    <td bgcolor="<? if (($num%2)==0) echo "$bgcolor" ?>"><? echo  $row_u["firstname"]; ?></td>
    <td bgcolor="<? if (($num%2)==0) echo "$bgcolor" ?>"><? echo  $row_u["surname"]; ?></td>
    <td bgcolor="<? if (($num%2)==0) echo "$bgcolor" ?>"> <div align="center"><font color="#666600">[ 
        <a href="edit_user.php?id=<? echo  $row_u["id"]; ?>" target="_self">edit</a> 
        ]</font></div></td>
  </tr>
  <?
  		$num++;
  		}  ?>
  <tr> 
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >จำนวน</td>
    <td > <div align="center"><? echo $num-1;?></div></td>
  </tr>
  <tr> 
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td > <a href="#top">Go to top</a></td>
  </tr>
  <?
  }
  ?>
</table>
<br>
<div align="right"><a href="#top">Go to top</a><br>
</div>

</body>
</html>