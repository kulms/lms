<? require ("../include/global_login.php");?>
<html>
<head>
	<title>Forum admin</title>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	<script language="javascript">
	<!-- 	
	function rename_check(){
		if(document.renameform.coursename.value==""){
			alert("You can't have an empty name field!");
			return false;
		}else{
			return true;
		}
	}
	function delete_check(){
		if(confirm("Do you really want to delete "+document.renameform.coursename.value+" and all it´s content?")){
			if(confirm("Are you really...REALLY sure?\nThis action can't be undone.")){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	} 
	//-->
	</script>
	
</head>
<body>
<?
if($courses!=0){
	$id=$courses;
}
if($person["admin"]==1){
	$getcourse=mysql_query("SELECT c.*,u.firstname,u.surname,u.email FROM courses c, users u WHERE c.id=$id AND u.id=c.users;");
}else{
	$getcourse=mysql_query("SELECT c.*,u.firstname,u.surname,u.email FROM courses c, users u WHERE c.id=$id 
							AND c.users=".$person["id"]." AND u.id=c.users;");
}
if($course_row=mysql_fetch_array($getcourse)){
?>
<h1 class="h1" align="center">Edit course</h1>
<br>
	<table border="0" cellpadding="2" cellspacing="0" align="center">
			<tr>
				<td class="main" colspan="2">Created by 
				<b><a href="mailto:<? echo mysql_result($getcourse,0,"email"); ?>">
				<? echo $course_row["firstname"]?>&nbsp;<? echo $course_row["surname"]; ?></a></b></td>
			</tr>
			<tr>
				<td class="main" align="left" valign="top">
					Name:
				</td>
				<form action="renamecourse.php" method="post" onSubmit="return rename_check();" name="renameform">
					<td class="main" align="left" valign="top">
						<input type="text" name="coursename" maxlength="10" size="15" value="<? echo mysql_result($getcourse,0,"name"); ?>" class="small">
						<input type="hidden" name="courses" value="<?echo $id?>">
					</td>
			</tr>
			<tr>
				<td class="main" align="left" valign="top">
					Info:
				</td>			
					<td class="main" align="left" valign="top">
					<textarea name="info" cols="100" rows="15" wrap="VIRTUAL" class="small"><? echo $course_row["info"]; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="main">
					<table width="50%" align="bleedleft">
						<tr>
							<td class="main"><b>I</b> want to accept every user and I will receive a mail for <br>
							every application in which I can respond instantantaniously.</td>
							<td valign="top">
							<input type="Radio" name="applyopen" value="0"<? if($course_row["applyopen"]==0){?> checked<?}?>></td>
						</tr>
						<tr>
							<td class="main">Everyone is accepted automatically</td>
							<td valign="top">
							<input type="Radio" name="applyopen" value="1"<? if($course_row["applyopen"]==1){?> checked<?}?>></td>
						</tr>
						<tr>
							<td class="main">The course is closed.</td>
							<td valign="top">
							<input type="Radio" name="applyopen" value="-1"<? if($course_row["applyopen"]==-1){?> checked<?}?>></td>
						</tr>

					</table>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="h5"><br>
					<b>User rights:</b><span class="main">(create)</span>
				</td>
			</tr>
				<?
					//check for folder privileges
				$folders=mysql_query("SELECT modules_type FROM wp_access WHERE courses=$id AND modules_type=-1;");
				if(mysql_num_rows($folders)!=0){
					$folder_check = 1;
				}else{
					$folder_check = 0;
				}?>
				<tr>
				<td>&nbsp;</td>
					<td class="main">
						<input type="checkbox" name="modules_type[]" value="-1"<? if($folder_check==1){?> checked<? } ?>>
						<img width=20 height=16 alt="" border="0" align="top" src="../images/folder.gif">
						<b>Folder</b>
					</td>
				</tr>
				<? $access=mysql_query("SELECT modules_type FROM wp_access WHERE courses=$id AND cases=0 
										AND groups=0 AND (users=0 OR users=".$person["id"].");");
				$acc=mysql_result($access,0,"modules_type");
				while($row=mysql_fetch_array($access)){
					$acc.=",";
					$acc.=$row["modules_type"];
				}
				$not_acc=mysql_query("SELECT DISTINCT mt.name,mt.id,mt.picture,mt.info 
									   FROM modules_type mt,wp_access wa WHERE mt.id NOT IN ($acc);");
				$mt=mysql_query("SELECT DISTINCT mt.name,mt.id,mt.picture,mt.info 
				 				 FROM modules_type mt, wp_access wa 
								 WHERE wa.modules_type=mt.id AND wa.courses=$id AND wa.cases=0 
								 AND wa.groups=0 AND (wa.users=0 OR wa.users=".$person["id"].");");
				while($row=mysql_fetch_array($mt)){
				?>
				<tr>
				<td>&nbsp;</td>
					<td class="main">
						<input type="checkbox" name="modules_type[]" value="<? echo $row["id"]; ?>"<? if($f_check!=1){?> checked<? } ?>>
						<img width=20 height=16 alt="" border="0" align="top" src="../<? echo $row["picture"]; ?>">
						<b><? echo $row["name"]?></b>
						<span class="small"><? echo $row["info"]; ?></span>
					</td>
				</tr>
				<? }
					//display all modules NOT selected in wp_access
				while($rows=mysql_fetch_array($not_acc)){?>
				<tr>
					<td>&nbsp;</td>
					<td class="main">
						<input type="checkbox" name="modules_type[]" value="<? echo $rows["id"]; ?>">
						<img width=20 height=16 alt="" border="0" align="top" src="../<? echo $rows["picture"]; ?>">
						<b><? echo $rows["name"]; ?></b>
						<span class="small"><? echo $rows["info"]; ?></span>
					</td>
				</tr>
				<?}?>
			<tr>
				<td>&nbsp;</td>
					<td>
						<br><input type="submit" value="Update" class="small">				
					</td>
				</form>
			</tr>
			<tr>
				<td class="main" align="left" valign="top">
					Delete:
				</td>
				<form action="deletecourse.php" method="post" onSubmit="return delete_check();" name="deleteform">
					<td class="main" align="left" valign="top">
						<input type="hidden" name="courses" value="<? echo $id?>">
						<input type="submit" value="Delete" class="small">
					</td>
				</form>
			</tr>		  
	</table>
<?
}else{
	$getuser=mysql_query("SELECT u.firstname,u.surname FROM users u, courses c WHERE c.users=u.id AND c.id=$id;");
	if(mysql_num_rows($getuser)!=0){
		$creator=mysql_result($getuser,0,"firstname")."&nbsp;".mysql_result($getuser,0,"surname");
?>
	<p>&nbsp;</p>
	<div class="h5" align="center">Sorry, you can't edit this course. It can only be edited by the administrator (<i><? echo $creator; ?></i>)</div>
	<? }
} ?>
</body>
</html>
