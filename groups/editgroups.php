<?require("../include/global_login.php");
if($groups==""){
	$groups=0;
}
if($cases==""){
	$cases=0;
}
if($folders==""){
	$folders=0;
}
?>
<html>
<head>
	<title>Group administration - folders</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script language="javascript">
function rename_check(){
	if(document.renameform.groupname.value==""){
		alert("You can't have an empty groupname");
		return false;
	}else{
		return true;
	}
}

function create_check(){
	if(document.createform.name.value==""){
		alert("You can't have an empty name");
		return false;
	}else{
		return true;
	}
}


function delete_check(){
	if(confirm("Do you really want to delete "+document.renameform.groupname.value+" and all it´s content?")){
		if(confirm("Are you really...REALLY sure?\nThis action can't be undone.")){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
</script>
</head>
<body bgcolor="#ffffff">
<div align="center">
<table width="360" align="center" bgcolor="#739FC4"  style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
  <tr>
    <td align="center" class="h3White">Edit / Add</td>
  </tr>
</table>
  <br>
<table width="360" border="0" cellpadding="2" cellspacing="0" bgcolor="#d4e2ed" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
  <?
if($groups==""){
	$groups=0;
}
if($cases==""){
	$cases=0;
}
if($folders==""){
	$folders=0;
}
$admincheck=mysql_query("SELECT id FROM wp WHERE courses=$courses AND users=".$person["id"]." AND admin=1;");
if(mysql_num_rows($admincheck)==0){
	$c_admin=0;
}else{
	$c_admin=1;
}
mysql_free_result($admincheck);
$check=mysql_query("SELECT * from groups WHERE id=$groups;");
$c=mysql_query("SELECT * from groups where id=$groups");

if($person["admin"]==1 || $c_admin==1 || mysql_result($c,0,"users")==$person["id"]){
	?>
  <tr>
    <td align="left" valign="top" class="main"> Rename group: </td>
    <form action="renamegroup.php" method="post" onSubmit="return rename_check();" name="renameform">
      <td colspan="2" class="main" align="right" valign="top">
<input type="text" name="groupname" maxlength="10" size="15" value="<?echo mysql_result($c,0,"name")?>" class="small">        
<input type="hidden" name="groups" value="<?echo $groups?>">
        <input type="hidden" name="cases" value="<?echo $cases?>">
        <input type="hidden" name="courses" value="<?echo $courses?>">
        <input name="submit" type="submit" class="small" value="Update">
    </form>
  </tr>
  <tr>
    <td align="left" valign="top" class="main"> Remove group: </td>
    <form action="../courses/delete.php" method="post" onSubmit="return delete_check();" name="deleteform">
      <td class="main" align="right" valign="top">
        <input type="hidden" name="del" value="group">
        <input type="hidden" name="group" value="<?echo $groups?>">
        <input type="hidden" name="case" value="<?echo $cases?>">
        <input type="hidden" name="folder" value="<?echo $folders?>">
        <input type="hidden" name="courses" value="<?echo $courses?>">
        <input name="submit" type="submit" class="small" value="Remove">
      </td>
    </form>
  </tr>
  <tr>
    <td align="left" valign="top" class="main"> Delete group: </td>
    <form action="../courses/delete.php" method="post" onSubmit="return delete_check();" name="deleteform">
      <td class="main" align="right" valign="top">
        <input type="hidden" name="delete" value="delete">
        <input type="hidden" name="del" value="group">
        <input type="hidden" name="group" value="<?echo $groups?>">
        <input type="hidden" name="case" value="<?echo $cases?>">
        <input type="hidden" name="folder" value="<?echo $folders?>">
        <input type="hidden" name="courses" value="<?echo $courses?>">
        <input name="submit" type="submit" class="small" value="Delete">
      </td>
    </form>
  </tr>
  <?
}
$ot=array();
if($person["admin"]==1 || $c_admin==1){
	$modulestype=mysql_query("SELECT mt.id,mt.name,mt.picture FROM modules_type mt WHERE active=1;");
	$othertype=mysql_query("SELECT modules_type FROM wp_access WHERE modules_type<0;");
	$ot[]=-1;
	$ot[]=-3;
}else{
	$modulestype=mysql_query("SELECT mt.id,mt.name,mt.picture FROM wp_access wa,modules_type mt WHERE wa.courses=$courses AND wa.modules_type=mt.id AND mt.active=1;");
	$othertype=mysql_query("SELECT modules_type FROM wp_access WHERE modules_type<0 AND courses=$courses;");
	while($row=mysql_fetch_array($othertype)){
		$ot[]=$row["modules_type"];
	}
}
$check=mysql_query("SELECT * from wp WHERE groups=$groups AND users=".$person["id"].";");
if((mysql_num_rows($modulestype)!=0 || count($ot)!=0) && (mysql_num_rows($check)!=0 || $person["admin"]==1 || $c_admin==1 )){
	?>
  <tr>
    <td colspan="2">
      <hr noshade size="2" width="300">
    </td>
  </tr>
  <form action="../courses/createmodule.php" name="createform" method="post" onSubmit="return create_check();">
    <input type="hidden" name="folders" value="<?echo $folders?>">
    <tr>
      <td align="left" valign="top" class="main"> Create new: </td>
      <td class="main"> <b><?echo $foldername?>/</b>
          <input type="text" name="name" class="small" maxlength="10">
      </td>
    </tr>
    <?
	while(list($key,$val)=each($ot)){
		switch($val){
			case -1:
				?>
    <tr>
      <td align="right">
        <input type="radio" name="modules_type" value="<?echo $val?>" checked  class="r-button">
      </td>
      <td class="main"> <img src="../images/folder.gif" alt="" width=18 height=16> <b>Folder</b> </td>
    </tr>
    <?
				break;
			case -2:
				if(($groups==0) && ($cases==0)){
				?>
    <tr>
      <td align="right">
        <input type="radio" name="modules_type" value="<?echo $val?>"  class="r-button">
      </td>
      <td class="main"> <img src="../images/cases.gif" alt="" width=20 height=16> <b>Case</b> </td>
    </tr>
    <?
				}
				break;
			case -3:
				if($groups==0){
				?>
    <tr>
      <td align="right">
        <input type="radio" name="modules_type" value="<?echo $val?>"  class="r-button">
      </td>
      <td class="main"> <img src="../images/groups.gif" alt="" width=20 height=16> <b>Group</b> </td>
    </tr>
    <?
				if($c_admin==1 || $person["admin"]==1){
					?>
    <tr>
      <td align="right"> </td>
      <td class="main"> <img src="../images/groups.gif" alt="" width=20 height=16> <b><a href="../groups/addexisting.php?courses=<?echo $courses?>&cases=<?echo $cases?>">Add existing group</a></b> </td>
    </tr>
    <?
				}
				}
				break;

		}
	}
	while($row=mysql_fetch_array($modulestype)){
		?>
    <tr>
      <td align="right">
        <input type="radio" name="modules_type" value="<?echo $row["id"]?>"  class="r-button">
      </td>
      <td class="main"> <img src="../<?echo $row["picture"]?>" align="top" width=18 height=16> <b><?echo $row["name"]?></b> </td>
    </tr>
    <?
	}
	?>
    <tr>
      <td colspan="2" align="center" class="small" valign="top">
        <input type="hidden" name="courses" value="<?echo $courses?>">
        <input type="hidden" name="cases" value="<?echo $cases?>">
        <input type="hidden" name="groups" value="<?echo $groups?>">
        <input name="submit" type="submit" value=" C r e a t e ">
      </td>
    </tr>
  </form>
  <?
}else{
	?>
  <tr>
    <td class="main" colspan="2"> Sorry!<br>
      You are not allowed to edit/add to this group.	 </td>
    </tr>
  <?	
}
?>
</table>
</div>
</body>
</html>
