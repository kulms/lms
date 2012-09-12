<?require("../include/global_login.php");
$selectb=mysql_query("SELECT * FROM webboard_name WHERE id='$webboard_name';");
$wbname=mysql_fetch_array($selectb);
?>

<html>
<head>
<title><?echo $wbname["webboard_name"] ?></title>
</head>

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

<body  bgcolor=#FFFFFF>
        <table border=0 width=100%>
        <tr>
    <td align=left valign=center> <font size=2 face="MS Sans Serif"><b>
    <?echo $wbname["webboard_name"] ?></font> </td>
        <td align=right><img src="img/arrow.gif">
        <a href="webboard.php?Category=<? echo $Category; ?>&page=<? echo $page; ?>&webboard_name=<?echo $webboard_name; ?>">แสดงคำถาม</a> |
        </td></tr>
        </table>
        <form method=post action="post.php?Category=<? echo $Category; ?>&page=<? echo $page; ?>&webboard_name=<?echo $webboard_name; ?>" name="webForm" onsubmit="return check()" ENCTYPE="multipart/form-data">
        <table border=1 bordercolor=#1E90FF bgcolor=E0FFFF cellpadding=2 cellspacing=0>
        <tr><td align=center>คำถาม</td><td><input type=text name="QTitle" size=50 maxlength=100></td></tr>
        <tr><td align=center valign=top>รายละเอียด</td><td><textarea rows="7" cols="50" name="QNote"></textarea></td></tr>
        <tr><td align=center>โดย</td><td><input type=text name="QName" size=50 maxlength=50></td></tr>
        <tr><td align=center>E-mail</td><td><input type=text name="QEmail" size=35 maxlength=50><font color=red><font></td></tr>
        <tr><td align=center colspan=2>
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
        </td></tr>

    <? // แนนรูป
    /*
        <tr><td align=center colspan=2>
                <table border=0>
                <tr><td colspan=2>เลือกรูปถ้าต้องการแนบรูป (ไม่เกิน 100k)<input type="file" name="QPic">
                </td></tr>
                </table>
        </td></tr>
        */?>
        </table>
        <br>
        <input type=submit value="ส่งคำถาม">
    <input type=reset value="ยกเลิก">
        </form>

        <font size=2 face="MS Sans Serif">
        [ <a href="../webboard/webboard.php?Category=<? echo $Category; ?>&page=<? echo $page; ?>&webboard_name=<?echo $webboard_name?>">แสดงคำถาม</a> ]
        <font>

        <hr color=1E90FF width=600>
</center>


<script language="JavaScript">
<!--
function check()
{
      var v1 = document.webForm.QTitle.value;
      var v2 = document.webForm.QNote.value;
      var v3 = document.webForm.QName.value;
        if ( v1.length==0)
           {
           alert("กรุณาป้อนคำถามครับ");
           document.webForm.QTitle.focus();
           return false;
           }
        else if (v2.length==0)
           {
           alert("กรุณาป้อนรายละเอียด");
           document.webForm.QNote.focus();
                   return false;
           }
        else if (v3.length==0)
           {
           alert("กรุณาป้อนชื่อผู้ถาม");
           document.webForm.QName.focus();
                   return false;
           }
        else
           return true;
}

function setsmile(what)
{
        document.webForm.QNote.value = document.webForm.elements.QNote.value+" "+what;
        document.webForm.QNote.focus();
}

//-->
</script>
</body>
</html>