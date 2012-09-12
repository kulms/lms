<?require("../include/global_login.php");
$info=mysql_query("SELECT id,users,name FROM modules WHERE users=".$person["id"]." AND id=$id;");
$userright=mysql_num_rows($info);
//if ($userright==1) {
?>
       <html>
        <head>
                <title></title>
                               <LINK REL=STYLESHEET TYPE="text/css" href="../main.css">
        </head>
        <body bgcolor="#ffffff">
        <div align="center"></div>
                <table bgcolor="AntiqueWhite" width="80%" cellpadding="6" cellspacing="0" border="1" align="center">
                <tr>
                        <td class="h3" colspan="5" align="center">Results for all participating users in <? echo mysql_result($info,0,"name"); ?></td>
                </tr>
                <tr>
                        <td class="info" align="center"><b>No.</b></td>
                        <td class="info" align="center"><b>Assignment</b></td>
                        <td class="info" align="center"><b>Participation Type</b></td>
                        <td class="info" align="center"><b>Nr of unsender now</b></td>
                        <td class="info" align="center"><b>In detail</b></td>
                </tr>
        <? $number=1;
           $assginfo=mysql_query("SELECT * FROM homework WHERE modules=$id AND users=".$person["id"]." ORDER BY id;");
            while($info=mysql_fetch_array($assginfo)){
            ?>

                                <tr bgcolor="white">
                                        <td class="info" align="center"><b><? echo $number ?></b></td>
                                        <td class="info"><b><? echo $info["name"] ?></b></td>
                                        <td class="info" align="center"><b><? if ($info["sendtype"] == 1) {echo "Text";} if ($info["sendtype"] == 2) {echo "URL";}if ($info["sendtype"] == 3) {echo "File";} ?></b></td>
<? $send=mysql_query("SELECT count(id) as send FROM homework_ans WHERE refid=".$info["id"]." AND modules=$id;");
   $stdall =mysql_query("SELECT count(users) as stdall FROM wp WHERE courses=$courses;");
   $count =    mysql_result($stdall,0,"stdall")- mysql_result($send,0,"send");
?>
                                        <td align="center" class="res"><b><?echo $count ?></b></td>
                                         <td class="info" align="center"><a href="showlost.php?modules=<? echo $id ?>&num=<?echo $number-1; ?>"><b>Click!</b></a></td>
                                </tr>
                        <? $number++;    }?>
                </table>
<br>
<? if ($pascal==1) { ?>
<table><tr><td class="info" align="center"><a href="convert.php?id=<?echo $id ?>">
Fill header information to all file </a>
</td></tr></table>
<? }
 ?>

<?// } else { echo "Permission Deny!!!"; }
?>

        </body>
        </html>