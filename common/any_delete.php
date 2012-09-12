<?
//Syntax:
//delete.php
//	del=[folder|case|group|module]
//	courses=[opt] course_id
//	folder=[opt] folder_id
//	case=[opt] case_id
//	group=[opt] group_id
//	module=[opt] module_id
//  delete=[opt] "delete" if delete groups instead of removing

require("../include/global_login.php");
require ("../include/colors.php");
include("../include/function.inc.php");

if($courses==""){$courses=0;}
if($group==""){$group=0;}
if($case==""){$case=0;}
if($folder==""){$folder=0;}
if($module==""){$module=0;}
if(${$del}==0){
	//if this is true, something is very wrong
	//so just in case.......
	$courses=-1;
	$case=-1;
	$group=-1;
	$folder=-1;
	$module=-1;
}
function delete($folder,$case,$group){
	global $person,$error,$courses;
	//MODULES error!!
	$m=mysql_query("SELECT mt.url_delete,m.id,m.users FROM modules m,wp,modules_type mt WHERE wp.courses=$courses AND wp.modules=m.id AND m.modules_type=mt.id AND wp.folders=$folder AND wp.cases=$case AND wp.groups=$group;");
	while($row=mysql_fetch_array($m)){
		if($row["users"]!=$person["id"]){
			$error=1;
		}
		mysql_query("UPDATE modules SET temp=1 WHERE users=".$person["id"]." AND id=".$row["id"].";");
		mysql_query("UPDATE wp SET temp=1 WHERE modules=".$row["id"]." AND courses=$courses AND cases=$case AND groups=$group;");
	}//FOLDERS error!
	$folders=mysql_query("SELECT f.id FROM folders f,wp WHERE wp.folders=f.id AND f.refid=$folder AND wp.courses=$courses AND wp.cases=$case AND wp.groups=$group;");
	while($row=mysql_fetch_array($folders)){
		mysql_query("UPDATE folders SET temp=1 WHERE id=".$row["id"].";");
		mysql_query("UPDATE wp SET temp=1 WHERE folders=".$row["id"]." AND courses=$courses AND cases=$case AND groups=$group;");
		delete($row["id"],$case,$group);
	}
	//CASES
	if($case==0 && $group==0){
		$cases=mysql_query("SELECT c.id FROM cases c,wp WHERE wp.folders=$folder AND wp.courses=$courses AND wp.cases=c.id AND wp.groups=0;");
		while($row=mysql_fetch_array($cases)){
			mysql_query("UPDATE cases SET temp=1 WHERE id=".$row["id"].";");
			mysql_query("UPDATE wp SET temp=1 WHERE courses=$courses AND cases=".$row["id"]." AND groups=0;");
			delete($folder,$row["id"],$group);
		}
	}
	//GROUPS
	if($group==0){
		$groups=mysql_query("SELECT g.id FROM groups g,wp WHERE wp.folders=$folder AND wp.courses=$courses AND wp.cases=$case AND wp.groups=g.id;");
		while($row=mysql_fetch_array($groups)){
			if($row["users"]!=$person["id"]){
				$error=1;
			}
			mysql_query("UPDATE wp SET temp=1 WHERE courses=$courses AND cases=$case AND groups=".$row["id"]." AND folders=$folder AND modules=0;");
			delete($folder,$case,$row["id"]);
		}
	}
}

$error=0;
switch($del){
	case "module":
		//***********insert modules_history***************
		$action="Delete";
		Imodules_h($module,$action,$person["id"],$courses);

		$check=mysql_query("SELECT users from modules WHERE id=$module;");
		if(mysql_result($check,0,"users")==$person["id"] || $person["admin"]==1){
			mysql_query("UPDATE modules SET temp=1 WHERE id=$module;");
			mysql_query("UPDATE wp SET temp=1 WHERE modules=$module;");
		}else{
			$error=1;
		}
		break;
	case "folder":
		mysql_query("UPDATE folders set temp=1 WHERE id=$folder;");
		mysql_query("UPDATE wp set temp=1 WHERE folders=$folder;");
		delete($folder,$case,$group);
		break;
	case "course":
		mysql_query("UPDATE courses set temp=1 WHERE id=$courses;");
		delete($folder,$case,$group);
		break;
	case "case":
		mysql_query("UPDATE cases set temp=1 WHERE id=$case;");
		mysql_query("UPDATE wp SET temp=1 WHERE cases=$case;");
		delete($folder,$case,$group);
		break;
	case "group":
		$check=mysql_query("SELECT * from groups where id=$group;");
		if($row=mysql_fetch_array($check)){
			if($row["users"]!=$person["id"] || $person["admin"]!=1){
				$error=1;
			}
		}
		if($delete=="delete"){
			mysql_query("UPDATE groups set temp=1 WHERE id=$group;");
			mysql_query("UPDATE wp set temp=1 WHERE groups=$group;");
			$delgroups=mysql_query("SELECT m.id from wp,modules m WHERE wp.modules=m.id AND wp.groups=$group;");
			while($row=mysql_fetch_array($delgroups)){
				mysql_query("UPDATE modules set temp=1 WHERE id=".$row["id"].";");
			}
		}else{
			mysql_query("UPDATE wp set temp=1 WHERE groups=$group AND folders=$folder AND cases=$case AND courses=$courses AND modules=0;");
			delete($folder,$case,$group);
		}
		break;
}
$check=mysql_query("SELECT * from wp where courses=$courses AND users=".$person["id"]." AND admin=1;");
if($error==0 || $person["admin"]==1 || mysql_num_rows($check)!=0){
	$checkmodules=mysql_query("SELECT mt.url_delete,m.id FROM modules_type mt, modules m WHERE m.temp=1 AND mt.id=m.modules_type;");
	while($row=mysql_fetch_array($checkmodules)){
		mysql_query("DELETE FROM login_modules WHERE modules=".$row["id"].";");
		if($row["url_delete"]!=""){
			$modules=$row["id"];
			$id=$row["id"];
			include("../".$row["url_delete"]);
		}
	}
	mysql_query("DELETE FROM modules WHERE temp=1;");
	mysql_query("DELETE FROM wp WHERE temp=1;");
	mysql_query("DELETE FROM folders WHERE temp=1;");
	mysql_query("DELETE FROM cases WHERE temp=1;");
	mysql_query("DELETE FROM groups WHERE temp=1;");
?>
	<html>
	<head>
		<title>update</title>
	<script language="javascript">
		function update(){
			top.ws_menu.location.reload();
		}
	</script>
	<link rel="STYLESHEET" type="text/css" href="../css.php">
	</head>
	<body onLoad="update()" bgcolor="#ffffff">
	<div align="center" class="main"><?$del?> deleted</div>
	</body>
	</html>
<?
}else{
	mysql_query("UPDATE wp set temp=0;");
	mysql_query("UPDATE folders set temp=0;");	
	mysql_query("UPDATE modules set temp=0;");
	mysql_query("UPDATE groups set temp=0;");
	mysql_query("UPDATE cases set temp=0;");?>
	<html>
	<head>
		<title>Not deleted</title>
	<link rel="STYLESHEET" type="text/css" href="../css.php">
	</head>
	<body bgcolor="<?echo $cBGcolor?>" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
	<p>&nbsp;</p>
	<div align="center" class="h5">Sorry, couldn't delete this <?$del?> since it contained modules created by other users.</div>
	</body>
	</html>
<?}?>
