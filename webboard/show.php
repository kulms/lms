<?require("../include/global_login.php");
$selectb=mysql_query("SELECT * FROM webboard_name WHERE id='$webboard_name';");
$wbname=mysql_fetch_array($selectb);

/*
 * **********************************************
 * **    PHP - WebBoard : Show Each Question   **
 * **********************************************
 * *                                            *
 * * Developed By : Sansak Chairattanatrai      *
 * * E-mail :  sansak@engineer.com              *
 * * UIN : 5590582                              *
 * * License : SamChai Public Soft Group(tm).   *
 * *                                            *
 * **********************************************
 */
require("config.inc.php");
?>
        <html>
        <head>
        <title><?echo $wbname["webboard_name"] ?></title>
    <link rel="STYLESHEET" type="text/css" href="../main.css">
        <style type="text/css">
        <!--
        BODY {font-family:;font-size="10"}
        A:link {text-decoration: none; color: blue }
        A:visited {text-decoration: none; color: blue }
        A:hover {text-decoration: none; color: darkorange }
        A:active {text-decoration: none; color: blue }
        p, div, td, ul li, ol li { font-family:  MS Sans Serif, Microsoft Sans Serif;  font-size: 10pt }
        -->
        </style>
        </head>

        <body bgcolor=#FFFFE0>
<div align="left" class="red"><?echo $wbname["webboard_name"] ?></div>
<?

        // ติดต่อ database เพื่ออ่านข้อมูล
        $sql = "select * from webboard_data where No='$No'";
        $result = mysql_db_query($dbname,$sql);
        $NRow = mysql_num_rows($result);

        if($NRow==0) { echo "Error"; exit(); }

        $row = mysql_fetch_array($result);
        // กำหนดค่าตัวแปร เพื่อนำไปแสดง
        $Question = $row["Question"];
        $Note = $row["Note"];
        $Name = $row["Name"];
        $Member = $row["Member"];
        $Email = $row["Email"];
        $Date = $row["Date"];
        $Image = $row["Image"];

        // ตรวจสอบรูปแบบการแสดง IP Address
        switch ($showIP) {
                case "ALL" : $IP = "(".$row["IP"].")"; break;
                case "BAN" : $IP = "(".substr($row["IP"],0,strrpos($row["IP"],".")).".*)"; break;
                case "NONE": $IP = ""; break;
                default : $IP = $row["IP"];
        }

        if($Member) {
                $sql = "select * from webboard_member where User='$Name'";
                $result = mysql_db_query($dbname,$sql);
                $NRow = mysql_num_rows($result);

                if($NRow==0) { echo "Error"; exit(); }

                $row = mysql_fetch_array($result);
                // กำหนดค่าตัวแปร เพื่อนำไปแสดง
                $ICQ = $row["ICQ"];
                $WebName = $row["WebName"];
                $URL = $row["URL"];
        }

        // แสดงข้อมูลของคำถาม(กระทู้)
        echo "<table border=1 width=600 bgcolor=white bordercolor=blue cellspacing=0 cellpadding=5>\n";
        echo "<tr><td align=center bgcolor=darkblue class=menu>\n";
        echo "\t<b>$Question</b>\n";
        echo "</td></tr>\n";

        echo "<tr><td>\n";
        echo "\n";
                echo "\t<table border=0 width=590 align=center>\n";
                echo "\t<tr><td class=info>\n";
                // ตรวจสอบว่ามีรูปหรือไม่
                if($Image) {
                        echo "\t\t<img src=\"showimage.php?table=data&No=$No\"><br>\n";
                }
                echo "\t\t$Note\n";
                echo "\t</td></tr>\n";
                echo "\t</table>\n";
                echo "<br>\n";
                echo "</td></tr>\n";

        echo "<tr><td>\n";
                echo "\t<table border=0 align=center width=100%>\n";
                echo "\t<tr><td align=left class=info>\n";
                if($Member){
                        echo "\t\t<a href=\"profile.php?Name=$Name\" target=\"$Name\"><img src=\"img/profile.gif\" border=0 alt=\"$Name's Profile\"></a>\n";
                        if($URL!="http://") {
                                echo "\t\t<a href='$URL' target='$URL'><img src=\"img/home.gif\" alt='$WebName' border=0></a>\n";
                        }
                        if($ICQ) {
                                echo "\t\t<img src=\"http://online.mirabilis.com/scripts/online.dll?icq=$ICQ&img=$ICQ_Image_Type"."online.gif\" alt='ICQ - $ICQ'>\n";
                        }
                }
                echo "\t</td>\n";
                echo "\t<td align=right class=res>\n";

                // ตรวจสอบการแสดงรูปกราฟฟิกซองจดหมาย
                if($Email!="") {
                        // เลือกระบบการส่งอีเมล์
                        switch ($s_mail) {
                                case "1" :         echo "\t\tโดยคุณ <a href=\"mail2me.php?wemail=$Email&name=$Name&question=$Question\" target=\"mail2me$No\">$Name <img src='../webboard/img/email.gif' border=0 alt='Mail to $Name'></a> \n"; break;
                                case "2" : echo "\t\tโดยคุณ <a href=mailto:$Email>$Name <img src='../webboard/img/email.gif' border=0 alt='Mail to $Name'></a> \n"; break;
                                default : echo "\t\tโดยคุณ <a href=\"mail2me.php?wemail=$Email&name=$Name&question=$Question\" target=\"mail2me\">$Name <img src='../webboard/img/email.gif' border=0 alt='Mail to $Name'></a> \n";
                        }
                }
                else {
                        echo "\t\tโดยคุณ $Name \n";
                }
                echo "<!\t\t$IP>\n";
                echo "\t\t[$Date]\n";
                echo "\t</td></tr>\n";
                echo "\t</table>\n";

        echo "</td></tr>\n";
        echo "</table>\n";
?>

<br><br>
<hr color=FF1493 width=600>
<br>

<?
        // ส่วนแสดงคำตอบของคำถาม(กระทู้)
        $sql = "select * from webboard_ans where QuestionNo='$No' order by No ". $order;
        $result = mysql_db_query($dbname,$sql);
        $NRow = mysql_num_rows($result);

        if($order=="ASC") $i = 1; else $i = $NRow;

        if($result==0) {
                echo "<b>Error</b>";
                exit();
        }

        // วนลูปแสดงข้อมูลที่อ่านได้
        while ($row = mysql_fetch_array($result)) {

                // กำหนดค่าตัวแปร เพื่อนำไปแสดง
                $QuestionNo = $row["No"];
                $Name = $row["Name"];
                $Member = $row["Member"];
                $Email = $row["Email"];
                $Msg = $row["Msg"];
                $Date = $row["Date"];
                $Image = $row["Image"];

                // ตรวจสอบรูปแบบการแสดง IP Address
                switch ($showIP) {
                case "ALL" : $IP = "(".$row["IP"].")"; break;
                case "BAN" : $IP = "(".substr($row["IP"],0,strrpos($row["IP"],".")).".*)"; break;
                case "NONE": $IP = ""; break;
                default : $IP = $row["IP"];
                }

                if($Member) {
                        $sql2 = "select * from webboard_member where User='$Name'";
                        $result2 = mysql_db_query($dbname,$sql2);
                        $NRow2 = mysql_num_rows($result2);

                        if($NRow2==0) { echo "Error"; exit(); }

                        $qrow = mysql_fetch_array($result2);
                        // กำหนดค่าตัวแปร เพื่อนำไปแสดง
                        $ICQ = $qrow["ICQ"];
                        $WebName = $qrow["WebName"];
                        $URL = $qrow["URL"];
                }

                echo "<table border=1 width=600 bordercolor=#1E90FF bgcolor=E0FFFF cellpadding=2 cellspacing=0>\n";
                echo "<tr><td>\n";

                        echo "\t<table border=0 width=590 align=center>\n";
                        echo "\t<tr><td class=info>\n";
                        // ตรวจสอบว่ามีรูปหรือไม่
                        if($Image) {
                                echo "\t\t<img src=\"showimage.php?table=ans&No=$QuestionNo\"><br>\n";
                        }
                        echo "\t\t$Msg\n";
                        echo "\t</td></tr>\n";
                        echo "\t</table>\n";

                        echo "\t<table border=0 width=590 align=center>\n";
                        echo "\t<tr><td align=left class=res>\n";
                        echo "\t\t\n";

                        // ตรวจสอบการแสดงรูปกราฟฟิกซองจดหมาย
                        if($Email!="") {
                                // เลือกระบบการส่งอีเมล์
                                switch ($s_mail) {
                                        case "1" :         echo "\t\tโดยคุณ <a href=\"mail2me.php?wemail=$Email&name=$Name&question=$Question\" target=\"mail2me$No\">$Name <img src='../webboard/img/email.gif' border=0 alt='Mail to $Name'></a> \n"; break;
                                        case "2" : echo "\t\tโดยคุณ <a href=mailto:$Email>$Name <img src='../webboard/img/email.gif' border=0 alt='Mail to $Name'></a> \n"; break;
                                        default : echo "\t\tโดยคุณ <a href=\"mail2me.php?wemail=$Email&name=$Name&question=$Question\" target=\"mail2me\">$Name <img src='../webboard/img/email.gif' border=0 alt='Mail to $Name'></a> \n";
                                }
                        }
                        else {
                                echo "\t\tโดยคุณ $Name \n";
                        }
                        echo "<! \t\t$IP >\n";
                        echo "\t\t[$Date] #$QuestionNo ($i/$NRow)\n";
                        echo "\t\t</font>\n";
                        echo "\t</td>\n";

                        echo "\t<td align=right>\n";
                        if($Member){
                                echo "\t\t<a href=\"profile.php?Name=$Name\" target=\"$Name\"><img src=\"img/profile.gif\" border=0 alt=\"$Name's Profile\"></a>\n";
                                if($URL!="http://") {
                                        echo "\t\t<a href='$URL' target='$URL'><img src=\"img/home.gif\" alt='$WebName' border=0></a>\n";
                                }
                                if($ICQ) {
                                        echo "\t\t<img src=\"http://online.mirabilis.com/scripts/online.dll?icq=$ICQ&img=$ICQ_Image_Type"."online.gif\" alt='ICQ - $ICQ'>\n";
                                }
                        }
                        echo "\t</td>\n";
                        echo "\t</tr></table>\n";

                echo "</td></tr>\n";
                echo "</table>\n\n";
                echo "<br><hr color=FF1493 width=600><br>\n\n";
                if($order=="ASC") $i++; else $i--;
        }

?>

<? // ฟอร์มรับข้อมูลของคำตอบ
?>
<form method=post action="reply.php?Category=<? echo $Category;?>&No=<? echo $No ?>&webboard_name=<?echo $webboard_name?>" name="webForm" onsubmit="return check()" ENCTYPE="multipart/form-data">
<table border=1 bordercolor=#FF8C00 bgcolor=#FFDEAD cellpadding=2 cellspacing=0>
<tr bgcolor=000000><td align=center class="red"><b>ร่วมตอบคำถาม</b>
</td></tr>
<tr><td><table border=0>
<tr>
  <td align=right valign=top>ความคิดเห็น</td>
  <td><textarea name="Msg" cols=50 rows=5 class="info"></textarea></td>
</tr>
<tr>
  <td align=right>โดย</td>
  <td><input size=50 type=text name="MsgBy" maxlength=50></td>
</tr>
<tr>
  <td align=right>Email</td>
  <td><input size=35 type=text name="Email" maxlength=50><font color=red><font></td>
</tr>
</table>
</td></tr>
<tr>
  <td align=center>
  <a href="javascript:setsmile(':smile:')"><img src="pic/smile.gif" border=0></a>
        <a href="javascript:setsmile(':sad:')"><img src="pic/frown.gif" border=0></a>
        <a href="javascript:setsmile(':red:')"><img src="pic/redface.gif" border=0></a>
        <a href="javascript:setsmile(':big:')"><img src="pic/biggrin.gif" border=0></a>
        <a href="javascript:setsmile(':ent:')"><img src="pic/blue.gif" border=0></a>
        <a href="javascript:setsmile(':shy:')"><img src="pic/shy.gif" border=0></a>
        <a href="javascript:setsmile(':sleepy:')"><img src="pic/sleepy.gif" border=0></a>
        <a href="javascript:setsmile(':sun:')"><img src="pic/sunglasses.gif" border=0></a>
        <a href="javascript:setsmile(':sg:')"><img src="pic/supergrin.gif" border=0></a>
        <a href="javascript:setsmile(':embarass:')"><img src="pic/embarass.gif"         border=0></a>
        <a href="javascript:setsmile(':dead:')"><img src="pic/dead.gif" border=0></a>
        <a href="javascript:setsmile(':cool:')"><img src="pic/cool.gif" border=0></a>
        <a href="javascript:setsmile(':clown:')"><img src="pic/clown.gif" border=0></a>
        <a href="javascript:setsmile(':pukey:')"><img src="pic/pukey.gif" border=0></a><br>
        <a href="javascript:setsmile(':eek:')"><img src="pic/eek.gif" border=0></a>
        <a href="javascript:setsmile(':roll:')"><img src="pic/sarcblink.gif" border=0></a>
        <a href="javascript:setsmile(':smoke:')"><img src="pic/smokin.gif" border=0></a>
        <a href="javascript:setsmile(':angry:')"><img src="pic/reallymad.gif" border=0></a>
        <a href="javascript:setsmile(':confused:')"><img src="pic/confused.gif"         border=0></a>
        <a href="javascript:setsmile(':cry:')"><img src="pic/crying.gif" border=0></a>
        <a href="javascript:setsmile(':lol:')"><img src="pic/lol.gif" border=0></a>
        <a href="javascript:setsmile(':yawn:')"><img src="pic/yawn.gif" border=0></a>
        <a href="javascript:setsmile(':devil:')"><img src="pic/devil.gif" border=0></a>
        <a href="javascript:setsmile(':tongue:')"><img src="pic/tongue.gif" border=0></a>
        <a href="javascript:setsmile(':alien:')"><img src="pic/aysmile.gif" border=0></a>
        <a href="javascript:setsmile(':tasty:')"><img src="pic/tasty.gif" border=0></a>
        <a href="javascript:setsmile(':crazy:')"><img src="pic/grazy.gif" border=0></a><br>
        <font color=blue>คลิกที่รูป เพื่อแทรกรูปลงในข้อความ</font>
  </td>
</tr>
<? // แนบรูป
/*
<tr>
  <td>
  <table border=0>
  <tr>
  <td>เลือกรูป <input type="file" name="QPic"></td>
  </tr>
  </table>
</tr> */
?>
</table>
<br>
<input type=submit value="Post message" name="submit">
<input type=reset value="Clear" name="reset">
</form>
<div class="red">
[<a href="javascript:window.close()">ปิดหน้าต่างนี้</a> ] </div>


<hr color=1E90FF width=600>

<script language="JavaScript">
<!--
function check()
{
      var v1 = document.webForm.Msg.value;
      var v2 = document.webForm.MsgBy.value;
        if ( v1.length==0)
           {
           alert("กรุณาป้อนรายละเอียด");
           document.webForm.Msg.focus();
           return false;
           }
        else if (v2.length==0)
           {
           alert("กรุณาป้อนชื่อ");
           document.webForm.MsgBy.focus();
                   return false;
           }
        else
           return true;
}

function setsmile(what)
{
        document.webForm.Msg.value = document.webForm.elements.Msg.value+" "+what;
        document.webForm.Msg.focus();
}
//-->
</script>

</body>
</html>