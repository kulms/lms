<?
	    include("../include/global_login.php");
	  include("config.inc.php");
		include("include/content.class.php");


$content= new Content($id,$courses,$person['id']);


if(isset($mid) && isset($submit)){
					$sql="UPDATE modules
								SET name='$mname'
								 WHERE id ='$mid' ";
					$rs = mysql_query($sql);				
?>

<script language="javascript">
			function update(){
				top.ws_menu.location.reload();
			}
		</script>
		<body  onLoad="update()">
		<div align="center" class="main">Module created...</div>
		</body>  

<?

}else if(isset($delete)){
$dir =  $config['homepath']."/".$mid;
$exceptions = array(".", "..");
$content->delete_files($content,$dir,$exceptions,true);
			$sql = "DELETE FROM modules  WHERE id='$mid' ";
			$rs = mysql_query($sql);
			$sql2= "DELETE FROM con_lesson  WHERE ModulesID='$mid' ";
			$rs2 = mysql_query($sql2);
			
		?> 
		<script language="javascript">
					function update(){
						top.ws_menu.location.reload();
					}
				</script>
				<body  onLoad="update()">
				<div align="center" class="main">Module created...</div>
				</body>  

<?

}else if($id!=""){
 $sql="SELECT  c.id as cosID,c.name as cid,c.fullname as cname ,m.id as mod_id, m.name as mod_name
				FROM modules m, courses c
				WHERE  m.id='$id'
				AND c.id=m.courses 
				AND m.active='1' ";
				
$rs = mysql_query($sql);
$row =mysql_num_rows($rs);
     while($row=mysql_fetch_array($rs)){
			 $cosID = $row[cosID];
			 $cid=$row[cid];
			 $cname =$row[cname];
			 $mod_id =$row[mod_id];
			 $mod_name=$row[mod_name];
	 }

?><html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="STYLESHEET" type="text/css" href="../themes/<? echo $theme ?>/style/main.css">

<script language="Javascript" src="./js/mmopenwindow.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="./calendar/cal.js"></script>
<script language="JavaScript" type="text/javascript" src="./calendar/cal_conf.js"></script>
<script language="JavaScript" type="text/javascript" src="./js/admin_sel_course.js"></script>
<script language="javascript">
function iconfirmdel(a){
				if( confirm("คุณต้องการลบ " + a +" ใช่หรือไม่ ?") ){   
							return true;   //document.location =in_url; 
				 }else{
						 return false;
				 }
}
</script>

</head>
<body>
<br>
<br>
&nbsp;
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="1"  class="tdborder1">
  <form name="createFrm" method="post" action="admin.php?mid=<? echo $id ?>">
    <tr  class="boxcolor">
      <td height="27" colspan="2" class="Bcolor"><? echo $Content_UpdateCon ?></td>
    </tr>
    <tr  class="tdbackground2"> 
      <td height="27" colspan="2" align="center" class="bblack"><? echo $cid ?> : <? echo $cname?> </td>
    </tr>
    <tr align="center"  class="tdbackground_white"> 
      <td width="280" height="60" align="right"><? echo $Content_NewContent ?> :</td>
      <td align="left">&nbsp; <input name="mname" type="text" id="less_name" size="50" maxlength="50" value="<? echo $mod_name; ?>"></td>
    </tr>
    <tr valign="middle"  class="tdbackground3"> 
      <td height="30" align="center">&nbsp;</td>
      <td height="30" align="left">

	  <input type="submit"  class="button" name="submit" value="<? echo $strUpdate?>">  
	<input type="button"   class="button"  value="<? echo $strCancel?>" name="cancel" onClick="javascript: window.location='index.php?id=<? echo $id ?>';">
<input type="submit"  class="button" name="delete" value="<? echo $strDelete?>" onClick="return iconfirmdel('<? echo $mod_name; ?>')">  

	</td></tr>

</form>

</table>	
<br>&nbsp;
</body>
</html>

<?
 } else{   // Create new modules
 ?>

<script language="javascript">
			function update(){
				top.ws_menu.location.reload();
			}
		</script>
		<body  onLoad="update()">
		<div align="center" class="main">Module created...</div>
		</body>  

<?
 }
?>