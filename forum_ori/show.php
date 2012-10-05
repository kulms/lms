<?require("../include/global_login.php");

if(!settype($show,"integer")){
        $show=20;
}
if($show==0){
        $show=20;
}

?>
<html>
<head>
        <title></title>
<script LANGUAGE="JavaScript">
<!--
parent.aktiv=1;
function edit(id){
        window.open("edit.php?id=" + id + "&module=<?echo $module;?>", "edit", "width=550,height=300");
}
// -->
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<?
$getmodules=mysql_query("SELECT name,info FROM modules WHERE id=$module;");
if(mysql_num_rows($getmodules)!=0){
        $foruminfo = str_replace("\n","<br>",mysql_result($getmodules,0,"info"));
        $forumname = mysql_result($getmodules,0,"name");
}
?>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<center>
<table border=0 cellpadding=0 cellspacing=0 width="100%">
<tr bgcolor="#ffffff">
        <td bgcolor="#000000">
        <table BORDER="0" CELLSPACING="1" CELLPADDING="1" width="100%">
                <tr bgcolor="#cccccc">
                        <td colspan="2" class="main" align="center"><b><?echo $forumname?></b></td>
                </tr><?if($foruminfo!=""){?>
                <tr bgcolor="#ffffff">
                        <td colspan="2" class="main" align="center"><?echo $foruminfo?>&nbsp;</td>
                </tr><?}?>
                <tr bgcolor="#cccccc">
                        <td class="main" width="100"> &nbsp; <b>Name</b></td>
                        <td class="main" width="85%"><b>Contribution</b></td>
                </tr>
                <?
                        $Getlist=mysql_query("SELECT u.id AS uid,u.firstname,u.surname,u.login,f.id,f.time,f.info FROM users u,forum_ori f WHERE f.modules=".$module." AND u.id=f.users ORDER BY f.id DESC");
             //           $admin=mysql_query("SELECT * FROM modules WHERE users=".person["$id"]." AND id=$id;");
                        while(($row=mysql_fetch_array($Getlist)) && ($show!=0)){
                                if($row["firstname"]=="" && $row["surname"]==""){
                                        $username=$row["login"];
                                }else{
                                        $username=$row["firstname"]."&nbsp;".$row["surname"];
                                }
                                ?><tr bgcolor="#ffffff" align="left" valign="top">
                                        <td class="main" valign="top">


                                        <? $courseid=mysql_query("SELECT courses FROM wp WHERE modules=".$module.";");
                                                                   $course=mysql_result($courseid,0,"courses");
                                                                   $checkadmin=mysql_query("SELECT users FROM courses WHERE id=".$course.";");
                                                                   if(($row["uid"]==$person["id"]) || mysql_result($checkadmin,0,"users")==$person["id"]){?>
                                                                   <a href="JavaScript:edit(<?echo $row["id"];?>)"><img src="../images/edit1.gif" width=18 height=13 alt="Edit your contibution" border="0" align="top"></a><?}?>
                                                <b><?echo $username?></b>
                                                <br><?echo date("d-m-Y
H:i",$row["time"]);?>
                                        </td>
                                        <td class="main" valign="top">
                                                <?echo $row["info"];?>
                                        </td>
                                </tr><?
                                $show--;
                        }
                                ?>
        </table>
        </td>
</tr>
</table>
<a href="show.php?show=-1&module=<?echo $module;?>" target="head_2" class="main">show all</a></center>
</body>
</html>
<?mysql_close();?>