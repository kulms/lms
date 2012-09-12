<?require ("../include/global_login.php");?>

<html>
<head>
        <title>Resources admin</title>
        <link rel="STYLESHEET" type="text/css" href="../main.css">
        <script language="javascript">
        <!--
        function rename_check(){
                if(document.renameform.resourcesname.value==""){
                        alert("You can't have an empty name");
                        return false;
                }else{
                        return true;
                }
        }
        function delete_check(){
                if(confirm("Do you really want to delete "+document.renameform.resourcesname.value+" and all it´s content?")){
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
if($modules!=0){
        $id=$modules;
}

if($person["admin"]==1){
        $getresources=mysql_query("SELECT m.*,u.firstname,u.surname,u.email FROM modules m, users u WHERE m.id=$id AND u.id=m.users;");
}else{
        $getresources=mysql_query("SELECT m.*,u.firstname,u.surname,u.email FROM modules m,users u WHERE m.id=$id AND m.users=".$person["id"]." AND u.id=".$person["id"].";");
}
if((mysql_num_rows($getresources)!=0)||($person["admin"]==1)){
?>
<h1 class="h1" align="center">Edit resources</h1>
<br>
        <table border="0" cellpadding="2" cellspacing="0" align="center">
<?if($person["admin"]==1){?>
                <tr>
                        <td colspan="2" class="main">Created by: <b><a href="mailto:<?echo mysql_result($getresources,0,"email")?>"><?echo mysql_result($getresources,0,"firstname")."&nbsp;".mysql_result($getresources,0,"surname")?></a></b></td>
                </tr>
<?}?>
                <tr>
                        <td class="main" align="left" valign="top">
                                Name:
                        </td>
                        <form action="renameresources.php" method="post" onSubmit="return rename_check();" name="renameform">
                                <td class="main" align="left" valign="top">
                                        <input type="text" name="resourcesname" maxlength="10" size="15" value="<?echo mysql_result($getresources,0,"name")?>" class="small">
                                        <input type="hidden" name="modules" value="<?echo $id?>">
                                </td>
                </tr>
                <tr>
                        <td class="main" align="left" valign="top">
                                Info:
                        </td>
                                <td class="main" align="left" valign="top">
                                                <textarea name="info" cols="50" rows="7" class="small" wrap="PHYSICAL"><?echo mysql_result($getresources,0,"info")?></textarea>
                                                 </td></tr>
                 <tr>
                        <td class="main" align="left" valign="top">
                                Student can upload:
                        </td>
                                <td class="main" align="left" valign="top">
                                                <input type="radio" name="stdlock" value="0" <? if (mysql_result($getresources,0,"stdlock")==0){echo "checked";}?>> No <br>
                                                <input type="radio" name="stdlock" value="1" <? if (mysql_result($getresources,0,"stdlock")==1){echo "checked";}?>> Yes

                                <br><input type="submit" value="Update" class="small">
                                </td>
                        </form>
                </tr>
                <tr>
                        <td class="main" align="left" valign="top">
                                Delete:
                        </td>
                        <form action="deleteresources.php" method="post" onSubmit="return delete_check();" name="deleteform">
                                <td class="main" align="left" valign="top">
                                        <input type="hidden" name="modules" value="<?echo $id?>">
                                        <input type="submit" value="Delete" class="small">
                                </td>
                        </form>
                </tr>
        </table>
<?

}else{
        $getuser=mysql_query("SELECT u.firstname,u.surname FROM users u, modules m WHERE m.users=u.id AND m.id=$id;");
        if(mysql_num_rows($getuser)!=0){
                $creator=mysql_result($getuser,0,"firstname")."&nbsp;".mysql_result($getuser,0,"surname");
?>
        <p>&nbsp;</p>
        <div class="h5" align="center">Sorry, you can't edit this resource. It can only be edited by it's creator (<i><?echo $creator ?></i>)</div>
        <?}
}?>
</body>
</html>