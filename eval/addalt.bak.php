<?
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include("./include/function.php");

		if($Submit=="true")
		{
				echo  trim($_POST[""]);
		
		}else{
?>
<html>
<head>
<title>A d d     A l t  e r n a t i v e s</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="./include/main.css" rel="stylesheet" type="text/css">
</head>
<body><a name="top">&nbsp;</a>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="24" bgcolor="#004080" class="bwhite">&nbsp; ระบบประเมินการสอนของอาจารย์โดยนิสิต ( Teaching 
      Evaluate System :TES )</td>
  </tr>
  <tr> 
    <td height="24" bgcolor="#E9E9F3">&nbsp; &nbsp; <b><a href="./cindex.php<? echo "?courses=$courses"; ?>">Home</a> 
      | <a href="./Add_usrdQ.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">เพิ่มคำถามจากผู้สอน</a> 
      | <a href="./result.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ผลการประเมินแสดงคะแนนเฉลี่ย</a> 
      | <a href="./numstd.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ผลการประเมินแสดงจำนวนผู้ตอบ</a>
	  <?  if(  ($totalstd-$std)>=1){ ?>| <a href="trackstd.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ตรวจสอบรายชื่อผู้ที่ยังไม่ได้ประเมิน</a><? } ?></b> 
    </td>
  </tr>
</table>
<form name="addaltfrm" method="post" action="./addalt.php">
  <input type="hidden" name="courses" value="<? echo $courses; ?>">
  <input type="hidden" name="qset" value="<? echo $qset; ?>">
  <input type="hidden" name="std" value="<? echo $std; ?>">
  <input type="hidden" name="totalstd" value="<? echo $totalstd; ?>">
  <input type="hidden" name="alts" value="<? echo $alts; ?>">
  <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#333333">
    <tr> 
      <td colspan="3" align="center">ระดับการประเมิน</td>
    </tr>
    <tr bgcolor="#E9E9F3"> 
      <td colspan="3">   &nbsp;  &nbsp;   ตัวอย่างการกรอกข้อมูล :</td>
    </tr>
    <tr bgcolor="#E9E9F3"> 
      <td align="right">ระดับที่ 1 
        <input name="exalt1" type="text" id="exalt" value="ดีมาก" maxlength="200" disabled readonly> 
        &nbsp; &nbsp;</td>
      <td colspan="2">&nbsp; คะแนน&nbsp; <input name="exscr1" type="text" id="exscr" value="5" size="5" disabled readonly></td>
    </tr>
    <tr bgcolor="#E9E9F3"> 
      <td align="right">ระดับที่ 2 
        <input name="exalt2" type="text" disabled value="ดี" maxlength="200" readonly> 
        &nbsp; &nbsp; </td>
      <td colspan="2"> &nbsp; คะแนน&nbsp; <input name="exscr2" type="text" disabled value="4" size="5" maxlength="5" readonly></td>
    </tr>
    <tr bgcolor="#E9E9F3"> 
      <td align="right">ระดับที่ 3 
        <input name="exalt3" type="text" disabled value="ปานกลาง" maxlength="200" readonly> 
        &nbsp; &nbsp; </td>
      <td colspan="2"> &nbsp; คะแนน&nbsp; <input name="exscr3" type="text" disabled value="3" size="5" maxlength="5" readonly></td>
    </tr>
    <tr bgcolor="#E9E9F3"> 
      <td align="right">ระดับที่ 4 
        <input name="exalt4" type="text" disabled value="พอใช้" maxlength="200" readonly> 
        &nbsp; &nbsp; </td>
      <td colspan="2"> &nbsp; คะแนน&nbsp; <input name="exscr4" type="text" disabled value="2" size="5" maxlength="5" readonly></td>
    </tr>
    <tr bgcolor="#E9E9F3"> 
      <td align="right">ระดับที่ 5 
        <input name="exalt5" type="text" disabled value="ควรปรับปรุง" maxlength="200" readonly> 
        &nbsp; &nbsp; </td>
      <td colspan="2"> &nbsp; คะแนน&nbsp; <input name="exscr5" type="text" disabled value="1" size="5" maxlength="5" readonly></td>
    </tr>
    <tr bgcolor="#E9E9F3">
      <td height="22" colspan="3">  &nbsp;  &nbsp;  <u>หมายเหตุ</u> &nbsp;  <font color="red"><b>***</b></font>    ข้อมูลที่กรอกจะถูกเก็บตามลำดับ (ลำดับมีความสำคัญ) <font color="red"><b>***</b></font> 
	  <br>&nbsp; &nbsp;  รูปแบบข้อมูลที่กรอก : ระดับการประเมิน - ตัวอักษร, &nbsp;  คะแนน - ตัวเลข</td>
    </tr>
    <tr> 
      <td height="22" colspan="3"> &nbsp; &nbsp; เพิ่มจำนวนระดับการประเมินเป็น
<!--  -->      
		<select name="alt" id="alt">
          <option value="1" selected onChange="<? echo "javascript:  $alt=1; window.location='addalt.php?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd&alts=$alts&alt=1';"; ?>">1</option>
          <option value="2" onChange="<? echo "javascript: $alt=2; window.location='addalt.php?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd&alts=$alts&alt=2';"; ?>">2</option>
          <option value="3" onChange="<? echo "javascript: $alt=3; window.location='addalt.php?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd&alts=$alts&alt=3';"; ?>">3</option>
          <option value="4" onChange="<? echo "javascript: $alt=4; window.location='addalt.php?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd&alts=$alts&alt=4';"; ?>">4</option>
        </select>  ลำดับ
		</td>
    </tr>
	<?   $cnt=1;
			while($alt>=$cnt){ 
	?>
    <tr> 
      <td height="22" colspan="3"> &nbsp; &nbsp;  ลำดับที่  <? echo $cnt; ?></td>
    </tr>
    <tr> 
      <td align="right">ระดับที่ 1 
        <input name="<? echo $cnt; ?>alt1" type="text" maxlength="200"> &nbsp; &nbsp; </td>
      <td colspan="2"> &nbsp; คะแนน&nbsp; <input name="<? echo $cnt; ?>scr1" type="text" size="5" maxlength="5"></td>
    </tr>
    <tr> 
      <td align="right">ระดับที่ 2 
        <input name="<? echo $cnt; ?>alt2" type="text" maxlength="200"> &nbsp; &nbsp; </td>
      <td colspan="2"> &nbsp; คะแนน&nbsp; <input name="<? echo $cnt; ?>scr2" type="text" size="5" maxlength="5"></td>
    </tr>
    <tr> 
      <td align="right">ระดับที่ 3 
        <input name="<? echo $cnt; ?>alt3" type="text" maxlength="200"> &nbsp; &nbsp; </td>
      <td colspan="2"> &nbsp; คะแนน&nbsp; <input name="<? echo $cnt; ?>scr3" type="text" size="5" maxlength="5"></td>
    </tr>
    <tr> 
      <td align="right">ระดับที่ 4 
        <input name="<? echo $cnt; ?>alt4" type="text" maxlength="200"> &nbsp; &nbsp; </td>
      <td colspan="2"> &nbsp; คะแนน&nbsp; <input name="<? echo $cnt; ?>scr4" type="text" size="5" maxlength="5"></td>
    </tr>
    <tr> 
      <td align="right">ระดับที่ 5 
        <input name="<? echo $cnt; ?>alt5" type="text" maxlength="200"> &nbsp; &nbsp; </td>
      <td colspan="2"> &nbsp; คะแนน&nbsp; <input name="<? echo $cnt; ?>scr5" type="text" size="5" maxlength="5">
        &nbsp; 
        <? if($cnt>=2 && $cnt!=$alt){ echo "<a href=\"#top\"><b>Top</b></a>"; } ?>
      </td>
    </tr>
	<?    $cnt++;
			} 
	?>
	<? if($alt>=2){ echo "  <table width=\"500\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"><tr><td colspan=\"3\" align=\"right\"><a href=\"#top\"><b>Go to Top</b></a></td></tr></table>"; } ?>
    <!--
	<tr> 
      <td align="right">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
	-->
  </table>
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr> 
		  <td align="center" height="22" colspan="3"><br><input type="submit" name="Submit" value="A d d    A l t e r n a t i v e s"> &nbsp; <input name="b" type="button" id="b" onClick="javascript : window.location='addaltQ.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd&alts=$alts"; ?>';" value="B a c k"><br>&nbsp; </td>
		</tr>
	</table>
</form>
</body>
</html>
<? } ?>