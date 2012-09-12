<?require("../include/global_login.php");
$info=mysql_query("SELECT id,users,name FROM modules WHERE users=".$person["id"]." AND id=$modules;");
$userright=mysql_num_rows($info);
//if ($userright==1) {
?>
       <html>
        <head>
                <title></title>
                               <LINK REL=STYLESHEET TYPE="text/css" href="../main.css">
<script LANGUAGE="JavaScript">
<!--
parent.aktiv=1;
function edit(id){
window.open("showtext.php?id=" + id + "", "edit", "width=550,height=300");
}
// -->
</script>
</head>
        <body bgcolor="#ffffff">
        <div align="center"></div>
<?$next=mysql_query("SELECT id,modules FROM homework WHERE modules=$modules ORDER BY id;");
$count=mysql_query("SELECT count(id) as cnt FROM homework WHERE modules=$modules;");
$last=mysql_result($count,0,"cnt");
$hw_id=mysql_result($next,$num,"id");
$assginfo=mysql_query("SELECT * FROM homework WHERE id=$hw_id;");
$hwans=mysql_query("SELECT * FROM homework_ans WHERE refid=$hw_id AND modules=$modules ORDER BY time;");?>
                <table bgcolor="AntiqueWhite" width="80%" cellpadding="6" cellspacing="0" border="1" align="center">
                <tr><td COLSPAN="5"><table border=0 width="100%">
                        <tr><td class="res"><?if ($num > 0){ ?><a href="showdetail.php?num=<?echo $num-1; ?>&modules=<?echo $modules; ?>"><img src="../images/hback.gif" border="0"></a><? } ?></td>
                        <td class="info" align="center">ผู้ที่ยังไม่ได้ส่งการบ้านเรื่อง<div class="res"> " <? echo mysql_result($assginfo,0,"name"); ?> "</div></td>
                         <td class="res" align="right"><? if ($num < $last-1) { ?><a href="showdetail.php?num=<?echo $num+1; ?>&modules=<?echo $modules; ?>"><img src="../images/hnext.gif" border="0"><? } ?></td>
                </table></td>
                </tr>
                <tr>
                        <td class="info" align="center"><b>ID.</b></td>
                        <td class="info" align="center"><b>Name</b></td>
                </tr>
<?        if (mysql_num_rows($hwans) != 0) {
            $i=0;
            while($row=mysql_fetch_array($hwans)){
            $temp[$i] = $row["users"];
            $i=$i+1;
            } //end while
           $userinfo=mysql_query("SELECT id,login,firstname,surname,email FROM users ;");
//              $userinfo=mysql_query("SELECT login,firstname,surname,email FROM users WHERE id<>".$row["users"].";");
            if ($userinfo != null) {
            while($row1=mysql_fetch_array($userinfo)){
               $flag=0;
               $i=0;
               while ($temp[$i] <> null) {
                    if($row1[0]==$temp[$i]) {
                       $flag=1;
                       exit();
                    }
                    $i = $i+1;
               }
               if ($flag==0) {
            ?>

                                <tr bgcolor="silver">
                                        <td class="info" align="center"><b><a href="mailto:<?echo mysql_result($userinfo,0,"email") ?>"><? echo mysql_result($userinfo,0,"login") ?></a></b></td>
                                        <td class="info"><b><? echo  mysql_result($userinfo,0,"firstname") ?> <?echo  mysql_result($userinfo,0,"surname") ?></b></td>
                                </tr>
           <?} }
            } else { echo "<tr><td colspan=2><center>ส่งการบ้านครบทุกคนแล้ว</center></td></tr>"; }

         }?>
                </table>
<center><form><div class="res"><input type="button" value="Back" onClick="{location='index.php?id=<?echo $modules?>';}"></form></center></div>
<?//  } else { echo "Permission Deny!!!"; }
?>

        </body>
        </html>