<?require("../include/global_login.php");
/*
 * **********************************************
 * **     PHP - WebBoard : Delete Question     **
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
<title>PHP Uiltemate Webboard 2.00</title>
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

<body background="../webboard/img/whpaper.gif">
        <font size=2 face="Arial,MS Sans Serif">
    <h2><font color=blue> ระบบลบข้อมูลของ PHP - Ultimate Webboard <font color=red>2.00</font> </font></h2>
        </font>

<?
        // ตรวจสอบการ login
        if($action=="login") {
                if($aid!=$admin || $apwd!=$admin_pwd) {
                        err_msg("Error : Admin ID and Password","กรุณาตรวจสอบอีกครั้ง","");
                }
        }

        // ตรวจสอบการลบ
        else if($action=="delete") {
                del_QA($mode,$qno,$ano);
                exit();
        }

        else {
                err_msg("Error : Method","กรุณา Login ก่อนเข้าระบบ","admin.html");
        }

?>
        <center>

        <!-- ฟอร์มรับหมายเลขของ คำถาม-คำตอบ -->
        <font size=3 face='MS Sans Serif'><b>รหัสถูกต้อง</b></font><br>
        <form method=post action="admindel.php?action=delete">
        <table border=0>
        <tr><td>
                <table border=1 width=280 bordercolor=#1E90FF bgcolor=E0FFFF cellpadding=2 cellspacing=0>
                        <tr><td><input type="radio" name="mode" value="question">หมายเลขคำถาม<br><center>(กระทู้)</center></td>
                        <td><input type="text" name="qno" size=20 maxlength=20></td></tr>
                </table>
                <br>
                <table border=1 width=280 bordercolor=#1E90FF bgcolor=E0FFFF cellpadding=2 cellspacing=0>
                        <tr><td><input type="radio" name="mode" value="answer">หมายเลขคำตอบ</td>
                        <td><input type="text" name="ano" size=20 maxlength=20></td></tr>
                </table>
        </td></tr>
        </table>
        <br>
        <input type="submit" value="> ลบ <">
        <input type="reset" value="ยกเลิก">
        </form>

        <? footer(); ?>

        </center>
</body>
</html>

<?
        // function ที่ใช้ในการลบ คำถาม-คำตอบ
function del_QA($mode,$qno,$ano) {
require("../include/global_login.php");
        require("config.inc.php");

        // ตรวจสอบขั้นตอนและค่าที่ส่งมาว่าถูกต้องหรือไม่
        if(!$mode) {
                err_msg("Error : Method","กรุณาเลือกวิธีลบด้วย","");
        }
        if($mode=="question" && !$qno) {
                err_msg("Error : Method","กรุณาใส่หมายเลขคำถาม(กระทู้)ด้วย","");
        }
        if($mode=="answer" && !$ano) {
                err_msg("Error : Method","กรุณาใส่หมายเลขคำตอบด้วย","");
        }

        $num = ($mode=="question") ? $qno : $ano;
        $table = ($mode=="question") ? "webboard_data" : "webboard_ans";
        $msg = ($mode=="question") ? "คำถาม(กระทู้)" : "คำตอบ";

        // ตรวจสอบว่ามคำถาม(กระทู้) และคำตอบีนี้หรือไม่
        mysql_connect($host,$user,$passwd);
        $sql = "select * from $table where No='$num'";
        $result = mysql_db_query($dbname,$sql);
        $NRow = mysql_num_rows($result);

        if($NRow==0) {
                err_msg("ไม่พบ$msg หมายเลข $num ในฐานข้อมูล","กรุณาตรวจสอบหมายเลขอีกครั้ง","");
        }

        if($mode=="question") {
                // sql string ที่ใช้ในการลบ คำถาม(กระทู้) และคำตอบของกระทู้นั้นๆ
                $del_question = "DELETE FROM webboard_data WHERE No='$num'";
                $del_answer = "DELETE FROM webboard_ans WHERE QuestionNo='$num'";
                $result1 = mysql_db_query($dbname,$del_question);
                $result2 = mysql_db_query($dbname,$del_answer);

                if(!$result1 && !$result2) {
                        err_msg("มีข้อผิดพลาดที่ระบบ","กรุณาแจ้ง admin ให้ตรวจสอบด้วยครับ","");
                }
                else {
                        echo "<center>";
                        echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
                        echo "<tr><td align=center>";
                        echo "<font size=2 face='MS Sans Serif'>";
                        echo "<font size=3 color=red><b>ลบข้อมูลเรียบร้อยแล้ว</b></font><br><br>";
                        echo "$msg หมายเลข <font color=blue><b>$num</b></font> และคำตอบทั้งหมด ได้ถูกลบออกจากฐานข้อมูลแล้วครับ";
                        echo "</font></td></tr></table>";
                        echo "<br><hr width=500 color=blue>";
                        echo "<font size=2 face='MS Sans Serif'>";
                        echo "[<a href='javascript:history.back(1)'>Back</a>]";
                        echo "</font>";
                        echo "</center>";
                        exit();
                }
        }

        else {
                $del_sql = "DELETE FROM webboard_ans WHERE No='$num'";
                $result = mysql_db_query($dbname,$del_sql);

                if(!$result) {
                        err_msg("มีข้อผิดพลาดที่ระบบ","กรุณาแจ้ง admin ให้ตรวจสอบด้วยครับ","");
                }
                else {
                        echo "<center>";
                        echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
                        echo "<tr><td align=center>";
                        echo "<font size=2 face='MS Sans Serif'>";
                        echo "<font size=3 color=red><b>ลบข้อมูลเรียบร้อยแล้ว</b></font><br><br>";
                        echo "$msg หมายเลข <font color=blue><b>$num</b></font> ได้ถูกลบออกจากฐานข้อมูลแล้วครับ";
                        echo "</font></td></tr></table>";
                        echo "<br><hr width=500 color=blue>";
                        echo "<font size=2 face='MS Sans Serif'>";
                        echo "[<a href='javascript:history.back(1)'>Back</a>]";
                        echo "</font>";
                        echo "</center>";
                        exit();
                }
        }
}

function err_msg($topic,$detial,$url) {
        echo "<center>";
        echo "<table width=60% border=1 bordercolor=#ff69b4 bgcolor=#f0ffff cellpadding=2 cellspacing=0>";
        echo "<tr><td align=center>";
        echo "<font size=2 face='MS Sans Serif'>";
        echo "<font size=3 color=red><b>$topic</b></font><br><br>";
        echo $detial;
        echo "</font></td></tr></table>";
        echo "<br>";
        echo "<font size=2 face='MS Sans Serif'>";
        if(!$url) {
                echo "[<a href='javascript:history.back(1)'>Back</a>]";
        }
        else {
                echo "[<a href='$url'>Back</a>]";
        }
        echo "</font><br><br>";
        footer();
        echo "</center>";
        exit();
}

function footer() {
        echo "<hr color=1E90FF>";
        echo "<font size=1 face='MS Sans Serif'>";
        echo "<b>Copy<font color=FF1493>LEFT</font> and Powered By : <a href=mailto:sansak@engineer.com>Sansak</a></b>";
        echo "</font>";
}
?>