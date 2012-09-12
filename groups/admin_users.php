<?php
require("../include/global_login.php");

$check=mysql_query("SELECT * FROM wp WHERE users=".$person["id"]." AND courses=$courses AND admin=1;");
$check2=mysql_query("SELECT * FROM groups WHERE id=$groups;");
if(($person["admin"]==1 || mysql_num_rows($check)!=0 || mysql_result($check2,0,"users")==$person["id"]) && $courses!=0){
 if($update!="true"){
	if($courses==0){
		$course["id"]=0;
		$course["name"]="";
		$course["active"]=1;
		$course["applyopen"]=1;
		$course["info"]="";
		$course["users"]=$person["id"];
	}else{
		$check=mysql_query("SELECT * from groups where id=$groups;");
		$course=mysql_fetch_array($check);
	}
	?>
	<html>
	<head>
		<title>Course On Web - Groups</title>
	<script language="javascript">
	function startup(){
		document.course.elements["courseusers[]"].options[0]=null;
		document.course.elements["users[]"].options[0]=null;
	}
	function addadmin(){
		for(a=document.course.elements["users[]"].options.length-1;a>-1;a--){
			if(document.course.elements["users[]"].options[a].selected){
				document.course.elements["courseusers[]"].options[document.course.elements["courseusers[]"].options.length]=new Option(document.course.elements["users[]"].options[a].text,document.course.elements["users[]"].options[a].value);
				document.course.elements["users[]"].options[a]=null;
			}
		}
		mark_all();
	}
	function removeadmin(){
		for(a=document.course.elements["courseusers[]"].options.length-1;a>-1;a--){
			if(document.course.elements["courseusers[]"].options[a].selected){
				document.course.elements["users[]"].options[document.course.elements["users[]"].options.length]=new Option(document.course.elements["courseusers[]"].options[a].text,document.course.elements["courseusers[]"].options[a].value);
				document.course.elements["courseusers[]"].options[a]=null;
			}
		}
		mark_all();
	}
	function mark_all(){
		for(a=0;a<document.course.elements["courseusers[]"].options.length;a++){
			document.course.elements["courseusers[]"].options[a].selected=true;
		}
	}
		
	function sendform(){
		mark_all();
		if(confirm('Make sure that all the members are selected (highlighted) in the memberslist.\nOK to send?')){
			document.course.submit();
		}
	}
	</script>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	<link rel="STYLESHEET" type="text/css" href="main.css">
	<link rel="STYLESHEET" type="text/css" href="faq.css">
	</head>
	
	<?php if(($tab == 1) || $tab == '') {?>
	<body bgcolor="#ffffff" onLoad="startup()">
	<?php } else { ?>
	<body bgcolor="#ffffff">
	<?php }?>
	
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center" background="../images/headerbg.gif" height="53">
  <tr> 
    <td class="menu" align="center"><b>Edit Group Members</b></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
		<?php if(($tab == 1) || $tab == '') {?>
		<table border="0" cellpadding="0" cellspacing="0">
				<td height="28" valign="middle" width="3">
				<img src="images/tabSelectedLeft.png" width="3" height="28" border="0" alt="" /></td>
				<td valign="middle" nowrap="nowrap"  background="images/tabSelectedBg.png">&nbsp;
				<a href="?tab=1&courses=<?php echo $courses;?>&groups=<? echo $groups;?>">Manual Edit Group</a>&nbsp;</td>
				<td valign="middle" width="3"><img src="images/tabSelectedRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="images/shim.gif" height="1" width="3" /></td>
				<td height="28" valign="middle" width="3"><img src="images/tabLeft.png" width="3" height="28" border="0" alt="" /></td>
				<td valign="middle" nowrap="nowrap"  background="images/tabBg.png">&nbsp;
				<a href="?tab=0&courses=<?php echo $courses;?>&groups=<? echo $groups;?>">Filtering Edit Group</a>&nbsp;</td>
				<td valign="middle" width="3"><img src="images/tabRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="images/shim.gif" height="1" width="3" /></td>
			</table>
			<?php } else { ?>
			<table border="0" cellpadding="0" cellspacing="0">
				<td height="28" valign="middle" width="3">
				<img src="images/tabLeft.png" width="3" height="28" border="0" alt="" /></td>
				<td valign="middle" nowrap="nowrap"  background="images/tabBg.png">&nbsp;
				<a href="?tab=1&courses=<?php echo $courses;?>&groups=<? echo $groups;?>">Manual Edit Group</a>&nbsp;</td>
				<td valign="middle" width="3"><img src="images/tabRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="images/shim.gif" height="1" width="3" /></td>
				<td height="28" valign="middle" width="3"><img src="images/tabSelectedLeft.png" width="3" height="28" border="0" alt="" /></td>
				<td valign="middle" nowrap="nowrap"  background="images/tabSelectedBg.png">&nbsp;
				<a href="?tab=0&courses=<?php echo $courses;?>&groups=<? echo $groups;?>">Filtering Edit Group</a>&nbsp;</td>
				<td valign="middle" width="3"><img src="images/tabSelectedRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="images/shim.gif" height="1" width="3" /></td>
			</table>
			<?php } ?>				
		</td>
	</tr>
	<tr>
		<td width="100%" colspan="9" class="tabox">
		<!--  in class Users -->
		<?php
		if($tab == '') 
		{
			$tab = 1;
		}		
				
		if($tab==1) {
		?>
		<br>
		<table border="0" cellpadding="5" cellspacing="0" align="center" class="std">
		  <form action="admin_users.php" method="post" name="course">
			<input type="hidden" name="courses" value="<?php echo $courses?>">
			<input type="hidden" name="groups" value="<?php echo $groups?>">
			<input type="hidden" name="update" value="true">
			<tr> 
			  <td class="hilite" align="center"> 
				<?php
					$check=mysql_query("SELECT * from users WHERE id=".$course["users"].";");
					?>
				Group created by: <b> <?php echo mysql_result($check,0,"firstname")." ".mysql_result($check,0,"surname")?></b> 
			  </td>
			</tr>
			<?php
				$users=mysql_query("SELECT DISTINCT u.* FROM users u,wp 
									WHERE u.active=1 AND wp.courses=$courses AND wp.users=u.id AND wp.admin=0 
									ORDER BY u.firstname ASC,u.surname ASC;");
				$admins=mysql_query("SELECT DISTINCT u.id,u.surname,u.firstname 
									 FROM users u,wp,groups g 
									 WHERE g.id=".$course["id"]." AND g.id=wp.groups AND wp.users=u.id AND u.active=1 AND wp.admin=0
									 ORDER BY u.firstname ASC, u.surname ASC;");
				?>
			<tr> 
			  <td class="std" align="center"> <table border="0" cellpadding="2" cellspacing="0">
				  <tr> 
					<td align="center" class="small" valign="top"> <b>Members</b><br> 
					  <select multiple name="courseusers[]" size="15"  style="font-size:14px">
						<option value="0">---------------------------- 
						<?php
									while($row=mysql_fetch_array($admins)){
									?>
						<option value="<?php echo $row["id"]?>"> <?php echo $row["firstname"]."_".$row["surname"]."_(".$row["id"].")"?> 
						<?php
									}
									?>
					  </select> </td>
					<td align="center" class="small" valign="top"> <br>
					  <br> <input type="button" value=" << " onClick="addadmin()" class="button"> <br>
					  <br> <input type="button" value=" >> " onClick="removeadmin()" class="button"> 
					</td>
					<td align="center" class="small" valign="top"> <b>Other users</b><br>
                    <select multiple name="users[]" size="15"  style="font-size:14px">
                      <option value="0">---------------------------- 
                      <?php
									if(mysql_num_rows($admins)!=0){
										mysql_data_seek($admins,0);
									}
									$mypos=0;
									while($row=mysql_fetch_array($users)){
										$show=1;
										if($mypos<mysql_num_rows($admins)){
											if(mysql_result($admins,$mypos,"id")==$row["id"]){
												$show=0;
												$mypos++;
											}
										}
										if($show==1){
										?>
                      <option value="<?php echo $row["id"]?>"> <?php echo $row["firstname"]."_".$row["surname"]."_(".$row["id"].")"?> 
                      <?php
										}
									}
									?>
                    </select> </td>
				  </tr>
				</table></td>
			</tr>
			<tr> 
			  <td align="center" class="hilite" valign="top"> <input type="button" value="  U p d a t e  " onClick="sendform()" class="button"> 
			  </td>
			</tr>
		  </form>
		</table>
		<br>
		<?php						
		} else {

			$users=mysql_query("SELECT DISTINCT u.* FROM users u,wp 
								WHERE u.active=1 AND wp.courses=$courses AND wp.users=u.id AND wp.admin=0 
								ORDER BY u.firstname ASC,u.surname ASC;");
			$admins=mysql_query("SELECT DISTINCT u.id,u.surname,u.firstname 
								 FROM users u,wp,groups g 
								 WHERE g.id=".$course["id"]." AND not wp.groups=0 AND wp.users=u.id AND u.active=1 AND wp.admin=0 
								 ORDER BY u.firstname ASC, u.surname ASC;");								
		?>
		<script>		
		var checkflag = "false";
		function doNow()
		{
			void(d=document.append);
			void(el=d.getElementsByTagName('INPUT'));
			if (checkflag == "false")  {
			  for(i=0;i<el.length;i++)
				void(el[i].checked=1) 
				checkflag = "true";
			} else {
				for(i=0;i<el.length;i++)
				 void(el[i].checked=0) 
				checkflag = "false";	
			}		
		}		
		</script>
		<script language="JavaScript">
		function mouseOverRow(gId, onOver){	
			if(document.getElementById){
				if(onOver==1)
					//eval("document.getElementById('trE" + gId + "')").bgColor="#FFF5E8";
					eval("document.getElementById('trE" + gId + "')").bgColor="#B3F2EF";
					//eval("document.getElementById('trE" + gId + "')").bgColor="#FFFFFF";					
				else
					eval("document.getElementById('trE" + gId + "')").bgColor="#FFFFFF";		
			}//end if
		}//end function				
		</script>
		<form action="append.php" method="post" name="append">
		  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr> 				  
			  <td>&nbsp;</td>
			</tr>
			<tr> 				  
			  <td><strong>Member List : รายชื่อของสมาชิกที่ยังไม่ถูกจัดกลุ่ม</strong></td>
			</tr>
			<tr> 				  
			  <td>&nbsp;</td>
			</tr>
		  </table>
		  <table width="90%" border="0" cellspacing="1" cellpadding="3" class="std" align="center">										  
			  <tr> 
				<td> 
				<INPUT TYPE="checkbox" NAME="checkbox" VALUE="checkbox" class="r-button" onClick="javascript: doNow();">Check All / Uncheck All
				</td>
			  </tr>			  
				  <?php	
				  	$i=0;																
					while($row_users=mysql_fetch_array($users)){
						$flag = 0;						
						while($exist=mysql_fetch_array($admins))
						{
							if($row_users["id"] == $exist["id"])
								{								
									$flag = 1;											
									mysql_data_seek($admins,0);
									break;
								} 										
						}
																
						if($flag == 0)
						{
							//echo "New Member: ".$res_row["id"]."<br>";																		
							$student[ ] = $row_users["id"];
							
						
				   ?>
				   <tr id="trE<? echo $i;?>" onMouseOver="mouseOverRow('<? echo $i;?>', 1);" onMouseOut="mouseOverRow('<? echo $i;?>', 0);" bgcolor="#FFFFFF">
						<td> 									
						<input name="students[ ]" type="checkbox" value="<? echo $student[$i];?>" class="r-button">									  
				   <?php 
				   		echo "<b>".$row_users["login"]."</b> : ".$row_users["title"].$row_users["firstname"]."  ".$row_users["surname"]."<br>";
						$i++;
						}
					} // End While
					//echo $i;
				   ?>
				   
				</td>
			  </tr>
			  <tr> 
				<td> 
					<input type="submit" name="add_member" value="Add Member to Group" class="button">
					<input type="hidden" name="courses" value="<?php echo $courses?>">
					<input type="hidden" name="groups" value="<?php echo $groups?>">													
				</td>
			  </tr>
			</table>
		</form>
		<?php							 
				
		} // End if tab == 1			
		
		?>
</td>
</tr>
</table>

	</body>
	</html>
	<?php
 }else{
 	mysql_query("UPDATE wp set temp=1 WHERE groups=$groups AND not users=0 AND not admin=1;");
	if(is_array($courseusers)){
		while(list($key,$val)=each($courseusers)){
			$check=mysql_query("SELECT * from wp WHERE users=$val AND groups=$groups;");
			if(mysql_num_rows($check)!=0){
				mysql_query("UPDATE wp set temp=0 WHERE users=$val AND groups=$groups;");
			}else{
				mysql_query("INSERT INTO wp (users,groups) values($val,$groups);");
			}
		}
	}
	mysql_query("DELETE from wp where groups=$groups AND temp=1 AND not users=0 AND not admin=1;");
		?>
		<html>
		<head>
			<title>updated</title>
		<script language="javascript">
			function update(){
				top.ws_menu.location.reload();
			}
		</script>
		<link rel="STYLESHEET" type="text/css" href="../main.css">
		</head>
		<body onLoad="update()" bgcolor="#ffffff">
		<div align="center" class="main">Groupmembers saved...</div>
		</body>
		</html>
	<?php
//	header("Status: 302 Moved Temporarily");
//	header("Location:  ../courses/users.php?courses=$courses&groups=$groups");
 }
}else{
	//User don't have access to this script
	?>
	<html>
	<head>
	<title></title>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	</head>
	<body bgcolor="#ffffff">
	<p>&nbsp;</p>
	<div align="center" class="h3">Sorry, you are not permitted to create or edit a course!</div>
	</body>
	</html>
	<?php
}
?>
