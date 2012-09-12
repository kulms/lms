<?
require("../include/global_login.php");
?>
<html>
<head>
        <title>Course administration - folders</title>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">

<script language="javascript">
function rename_check(){
        if(document.renameform.foldername.value==""){
                alert("You can't have an empty foldername");
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
        if(confirm("Do you really want to delete "+document.renameform.foldername.value+" and all it's content?")){
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

  
  
 <table width="643" border="0" cellspacing="0" cellpadding="0" 
	    height="25"  background="../themes/<? echo $theme;?>/images/head_bg.gif">
	  <tr>
			<td width="21"></td>
			<td width="622"  class="headline" >
		 <b>Edit / Add</b>			</td>
	</tr>
</table>
 
 
  <br>
  <table width="360" border="0" align="center" cellpadding="2" cellspacing="0"  class="tdborder2">
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

if($folders!=0){
        $folder=mysql_query("SELECT DISTINCT f.name,f.users FROM folders f,wp WHERE f.id=$folders AND wp.folders=f.id;");
        if($person["id"]==mysql_result($folder,0,"users") || $person["admin"]==1 || $c_admin==1){
                $foldername=mysql_result($folder,0,"name");
                ?>
                <tr>
                        <td class="hilite" align="left" valign="top">
                                Rename folder:
                        </td>
                        <form action="renamefolder.php" method="post" onSubmit="return rename_check();" name="renameform">
                                <td colspan="2" class="main" align="right" valign="top">
                                        <input type="text" name="foldername" maxlength="10" size="15" value="<?echo mysql_result($folder,0,"name")?>" class="small">
                                        <input type="hidden" name="folders" value="<?echo $folders?>">
                                        <input type="hidden" name="courses" value="<?echo $courses?>">
                                        <input type="submit" value="Update" class="button"></form>
                                </td>
                </tr>
                <tr>
                        <td class="hilite" align="left" valign="top">
                                Delete folder:
                        </td>
                        <form action="delete.php" method="post" onSubmit="return delete_check();" name="deleteform">
                                <td class="hilite" align="right" valign="top">
                                        <input type="hidden" name="del" value="folder">
                                        <input type="hidden" name="folder" value="<?echo $folders?>">
                                        <input type="hidden" name="courses" value="<?echo $courses?>">
                                        <input type="hidden" name="case" value="<?echo $cases?>">
                                        <input type="hidden" name="group" value="<?echo $groups?>">
                                        <input type="submit" value="Delete" class="button">
                                </td>
                        </form>
                </tr>
                <?
        }
}
$ot=array();
if($person["admin"]==1 || $c_admin==1){
        $modulestype=mysql_query("SELECT mt.id,mt.name,mt.picture FROM modules_type mt WHERE mt.active=1;");
        $othertype=mysql_query("SELECT modules_type FROM wp_access WHERE modules_type<0;");
        $ot[]=-1;
        $ot[]=-2;
        $ot[]=-3;
}else{
        $modulestype=mysql_query("SELECT mt.id,mt.name,mt.picture FROM wp_access wa,modules_type mt WHERE wa.courses=$courses AND wa.modules_type=mt.id AND mt.active=1;");
        $othertype=mysql_query("SELECT modules_type FROM wp_access WHERE modules_type<0 AND courses=$courses;");
        while($row=mysql_fetch_array($othertype)){
                $ot[]=$row["modules_type"];
        }
}
if((mysql_num_rows($modulestype)!=0 || count($ot)!=0)){
        ?>
        <tr>
                <td colspan="2" height="5">
                       
                </td>
        </tr>
        <form action="createmodule.php" name="createform" method="post" onSubmit="return create_check();">
        <input type="hidden" name="folders" value="<?echo $folders?>">
        <tr>
                <td class="hilite" align="left" valign="top">
                        Create new:
                </td>
                <td class="hilite">
                        <b><?echo $foldername?>/</b><input type="text" name="name" class="text" maxlength="10">
                </td>
        </tr>
        <?
        while(list($key,$val)=each($ot)){
                switch($val){
                        case -1:
                                ?>
                                <tr>
                                        <td align="right">
                                                <input type="radio" name="modules_type" value="<?echo $val?>" checked class="r-button">
                                        </td>
                                        <td class="main">
                                                <img src="../images/folder.gif" alt="" width=18 height=16>
                                                <b>Folder</b>
                                        </td>
                                </tr>
                                <?
                                break;
                       /* case -2:
                                if(($groups==0) && ($cases==0)){
                                ?>
                                <tr>
                                        <td align="right">
                                                <input type="radio" name="modules_type" value="<?echo $val?>">
                                        </td>
                                        <td class="main">
                                                <img src="../images/cases.gif" alt="" width=20 height=16>
                                                <b>Case</b>
                                        </td>
                                </tr>
                                <?
                                }
                                break;*/
                        case -3:
                                if($groups==0){
                                ?>
                                <tr>
                                        <td align="right">
                                                <input type="radio" name="modules_type" value="<?echo $val?>" class="r-button">
                                        </td>
                                        <td class="main">
                                                <img src="../images/groups.gif" alt="" width=20 height=16>
                                                <b>Group</b>
                                        </td>
                                </tr>
                                <?
                                if($c_admin==1 || $person["admin"]==1){
                                        ?>
                                        <tr>
                                                <td align="right">
                                                </td>
                                                <td class="main">
                                                        <img src="../images/groups.gif" alt="" width=20 height=16>
                                                        <b><a href="../groups/addexisting.php?courses=<?echo $courses?>&cases=<?echo $cases?>&folders=<?echo $folders?>">Add existing group</a></b>
                                                </td>
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
                                <input type="radio" name="modules_type" value="<?echo $row["id"]?>" class="r-button">
                        </td>
                        <td class="main">
                                <img src="../<?echo $row["picture"]?>" align="top" width=18 height=16>
                                <b><?echo $row["name"]?></b>
                        </td>
                </tr>
                <?
        }
        ?>

        <tr>
                <td colspan="2" align="center"  valign="top">
                                <input type="hidden" name="courses" value="<?echo $courses?>">
                                <input type="hidden" name="cases" value="<?echo $cases?>">
                                <input type="hidden" name="groups" value="<?echo $groups?>">
								<input type="hidden" name="users" value="<?echo $person["id"]?>">
								
                        <input type="submit" value=" Create" class="button"> <input type="button"  value="Cancel" onClick="history.back();" class="button">
                </td>
        </tr>
        </form>
<?}?>
</table>

</body>
</html>