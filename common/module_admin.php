<?
require ("../include/global_login.php");
//require ("../include/colors.php");

if($id!=""){
	$modules=$id;
}else{
	$id=$modules;
}
	
if($person["admin"]==1){
	$getMod=mysql_query("SELECT m.*,u.firstname,u.surname,u.email FROM modules m,users u WHERE m.id=".$modules." AND m.users=u.id;");
}else{
	$getMod=mysql_query("SELECT m.*,u.firstname,u.surname,u.email FROM modules m,users u WHERE m.id=".$modules." AND m.users=u.id AND u.id=".$person["id"].";");
}
if($row=mysql_fetch_array($getMod)){
	$modtype=mysql_query("SELECT * from modules_type WHERE id=".$row["modules_type"].";");
	$mod=mysql_fetch_array($modtype);
?>
<html>
<head>
	<title>Administrate module</title>
	<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
	<script language="javascript">
	<!-- 	
	function rename_check(){
		if(document.renameform.elements["modulename"].value==""){
			alert("You can´t have an empty name");
		}else{
			document.renameform.submit();
		}
	}	
	function delete_check(){
		if(confirm("Do you really want to delete <?echo $row["name"]?> and all its content?")){
			if(confirm("Are you really...REALLY sure?\nThis action can´t be undone.")){
				location.href="any_delete.php?module=<?echo $modules?>&del=module";
			}
		}
	}
	function page_back(){
		history.back();
	} 
	//-->
	</script>
	
</head>
<body  bgcolor="FFFFFF" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<h1 class="h1">
<img src="../<?echo $mod["picture"]?>" width="16" height="16" border="0"> Edit <?echo $mod["name"]?>: <i><?echo $row["name"]?></i>
<hr noshade size="1" width="100%" color="<?echo $cBorder?>">
</h1>
<br>
<div align="center">
<table border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td class="main" >
			<table border="0" cellpadding="1" cellspacing="1" class="tdborder2">
				<? if($person["admin"]==1){?>
					<tr>
						<td colspan="2" class="hilite" >Created by: <b><a href="mailto:<?echo $row["email"]?>"><?echo $row["firstname"]."&nbsp;".$row["surname"]?></a></b></td>
					</tr>
				<?}?>
				<tr>
					<td class="hilite" align="left" valign="top" >
						<b>Name:</b>
					</td>
					<form action="module_rename.php" method="post" name="renameform">
						<td class="main" align="left" valign="top" >
							<input type="text" name="modulename" maxlength="10" size="15" value="<?echo $row["name"]?>" class="small">
							<input type="hidden" name="modules" value="<?echo $modules?>">
							<input type="hidden" name="courses" value="<?echo $courses?>">
						</td>
				</tr>
				<tr>
					<td class="hilite" align="left" valign="top" >
						<b>Info:</b>
					</td>			
						<td class="main" align="left" valign="top" >
								<textarea name="info" cols="50" rows="7" class="small" wrap="PHYSICAL"><?echo $row["info"]?></textarea>
						</td>
					</form>
				</tr>
				<tr>
					<td class="mainwhite" colspan="2"  height="18">
						&nbsp;&nbsp;
						<img src="../images/arrow.gif" width="7" height="7" alt="" border="0"> <a href="Javascript:rename_check()"><b class="mainwhite"><u>Update</u></b></a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<img src="../images/arrow.gif" width="7" height="7" alt="" border="0"> <a href="Javascript:delete_check()"><b class="mainwhite"><u>Delete</u></b></a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<img src="../images/arrow.gif" width="7" height="7" alt="" border="0"> <a href="Javascript:page_back()"><b class="mainwhite"><u>Back</u></b></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?

}else{
	$getuser=mysql_query("SELECT u.firstname,u.surname FROM users u, modules m WHERE m.users=u.id AND m.id=$id;");
	if(mysql_num_rows($getuser)!=0){
		$creator=mysql_result($getuser,0,"firstname")."&nbsp;".mysql_result($getuser,0,"surname");
?>
	<p>&nbsp;</p>
	<div class="h5" align="center">Sorry, you can't edit this module. It can only be edited by it's creator (<i><?echo $creator ?></i>)</div>
	<?}
}?>
</div>
</body>
</html>
