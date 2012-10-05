<?
require ("../include/global_login.php");

if($update!="true"){
        $users=mysql_query("SELECT * from users WHERE id=".$person["id"].";");
//        $contrib=mysql_query("SELECT * FROM forum f WHERE modules=".$module." and id=".$id." and users=".$person["id"].";");
     $contrib=mysql_query("SELECT * FROM forum_ori f WHERE modules=".$module." and id=".$id.";");
        if(mysql_num_rows($contrib)!=0){
                ?>
                <html>
                <head>
                        <title>Edit contribution</title>
                        <link rel="STYLESHEET" type="text/css" href="../main.css">
                </head>
                <body bgcolor="#ffffff" topmargin="0" leftmargin="0">
                <center>
                        <table border=1 cellpadding="10" cellspacing="0">
                                <form action="edit.php" method="post">
                                <tr>
                                        <td class="main" align="center">
                                                <h4 class="h4">Edit contribution</h4>
                                                <div class="res" align="center">The entire contibution will be deleted if you submit an empty string.</div>
                                                <textarea name="info" class="small" wrap="virtual" cols="40" rows="8"><?echo str_replace("<br>","\n",mysql_result($contrib,0,"info"));?></textarea>
                                                <br>
                                                <input type="submit" value="Update"><input type="reset" value="Reset">
                                                <input type="hidden" name="id" value="<?echo $id;?>">
                                                <input type="hidden" name="module" value="<?echo $module;?>">
                                                <input type="hidden" name="update" value="true">
                                                </form><div class="main">
                                                <form action="deletedistrib.php" method="post">
                                                <input type="hidden" name="id" value="<?echo $id; ?>">
                                                <input type="hidden" name="module" value="<?echo $module;?>">
                                                <input type="submit" value="Delete">
                                                <input type="button" value="Cancel" onClick="window.close()">
                                                </div>
                                                </form>

                                        </td>
                                </tr>
                                </table>
                </center>
                </body>
                </html>
                <?
        }else{
                ?> Cannot Edit ,ERROR!!!!!<?
        }
}else{
        $info=str_replace("\n","<br>",$info);
        if(strlen($info)<2){
           //     mysql_query("DELETE FROM forum WHERE id=".$id." AND modules=".$module." AND users=".$person["id"].";");
     mysql_query("DELETE FROM forum_ori WHERE id=".$id." AND modules=".$module.";");
        }else{
                $info=str_replace("'","&#039;",str_replace("\n","<br>",$info));
//      mysql_query("UPDATE forum set info='".str_replace("'","&#039;",$info)."' WHERE id=".$id." AND modules=".$module." and users=".$person["id"].";");
                mysql_query("UPDATE forum_ori set info='".str_replace("'","&#039;",$info)."' WHERE id=".$id." AND modules=".$module.";");
                $getprefs=mysql_query("SELECT u.email,m.name FROM users u, forum_ori_prefs fp, modules m WHERE fp.mail=1 AND fp.modules=$module AND u.id=fp.users AND m.id=$module;");
                while($mailrow=mysql_fetch_array($getprefs)){
                        mail($mailrow["email"],"Contribution edited in ".$mailrow["name"]."
in Course","Edited ".date("H:i, d-m-Y",time())." by ".$person["firstname"]."
".$person["surname"]."\n\nContribution:\n".str_replace("<br>","\n",$info),"From:admin@$SERVER_NAME");
                }

        }
?>
<script LANGUAGE="JavaScript">
<!--
function confirm(){
//        alert('OK, updated your contribution.');
        window.opener.parent.head_2.location.reload();
        self.close();
}
// -->
</script>

<body onLoad="confirm()">
<?
}
mysql_close();?>