<?   
	require("../include/global_login.php");
	$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
	$user_name = @mysql_result($users,0,"firstname")."  ".@mysql_result($users,0,"surname");
	$users_belong=mysql_query("SELECT * from users WHERE id=".$belong);
	$uname_belong = @mysql_result($users_belong,0,"firstname")."  ".@mysql_result($users_belong,0,"surname");
	$eval_res = mysql_query("SELECT * FROM evaluate WHERE eval_owner = ".$belong);	
?>
<html>
<head>
        <title>Exam Evaluate</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">

  <table width="70%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
    <tr align="center"> 
      <td width="100%" bgcolor="#739FC4"  class="bluenav" ><strong><font size="5">:-: 
        Exam Evaluation :-:</font></strong></td>
    </tr>
  </table>
<? if (mysql_num_rows($eval_res) == 0) {?>  
<br>
<table width="70%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
  <tr align="center"> 
    <td width="100%"  >ยังไม่มีข้อมูล</td>
  </tr>
</table>
<? } else {  ?>
<br>
<? 
	$i = 1;
	$color = 1;
	$bgcolor = "#d4e2ed";
	while ($row=mysql_fetch_array($eval_res)) {
		if ($color == 1) {
?>
<table width="70%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
  <tr align="center">
    <td bgcolor="#739FC4"  class="bluenav" ><strong>ความคิดเห็นที่  <? echo $i;?></strong></td>
  </tr>
  <tr align="center"> 
    <td width="100%" >
      <table width="80%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
        <tr align="center"> 
          <td colspan="4"  class="bluenav"  ><strong>Homework 
            Application</strong></td>
        </tr>
        <tr align="center"> 
          <td width="37%" align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดเด่น</strong></p></td>
          <td width="63%" align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea" cols="50" rows="6" class="pn-text"><? echo $row["home_comment1"];?></textarea></td>
        </tr>
        <tr align="center"> 
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดอ่อน</strong></p></td>
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea2" cols="50" rows="6" class="pn-text"><? echo $row["home_comment2"];?></textarea></td>
        </tr>
        <tr align="center"> 
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>ข้อควรปรับปรุง</strong></p></td>
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea3" cols="50" rows="6" class="pn-text"><? echo $row["home_comment3"];?></textarea></td>
        </tr>
      </table>
      <br>
      <table width="80%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
        <tr align="center"> 
          <td colspan="4"  class="bluenav" bgcolor="#739FC4" ><strong>Final Exam 
            Application</strong></td>
        </tr>
        <tr align="center"> 
          <td width="37%" align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดเด่น</strong></p></td>
          <td width="63%" align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea4" cols="50" rows="6" class="pn-text"><? echo $row["final_comment1"];?></textarea></td>
        </tr>
        <tr align="center"> 
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดอ่อน</strong></p></td>
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea5" cols="50" rows="6" class="pn-text"><? echo $row["final_comment2"];?></textarea></td>
        </tr>
        <tr align="center"> 
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>ข้อควรปรับปรุง</strong></p></td>
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea6" cols="50" rows="6" class="pn-text"><? echo $row["final_comment3"];?></textarea></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
		$color = 0;
		} else {
?>
<br>
<table width="70%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
  <tr align="center"> 
    <td bgcolor="#739FC4"  class="bluenav" ><strong>ความคิดเห็นที่ <? echo $i;?></strong></td>
  </tr>
  <tr align="center"> 
    <td width="100%" bgcolor="<? echo $bgcolor;?>" > <table width="80%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
        <tr align="center"> 
          <td colspan="4"  class="bluenav"  ><strong>Homework Application</strong></td>
        </tr>
        <tr align="center"> 
          <td width="37%" align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดเด่น</strong></p></td>
          <td width="63%" align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea7" cols="50" rows="6" class="pn-text"><? echo $row["home_comment1"];?></textarea></td>
        </tr>
        <tr align="center"> 
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดอ่อน</strong></p></td>
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea7" cols="50" rows="6" class="pn-text"><? echo $row["home_comment2"];?></textarea></td>
        </tr>
        <tr align="center"> 
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>ข้อควรปรับปรุง</strong></p></td>
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea7" cols="50" rows="6" class="pn-text"<? echo $row["home_comment3"];?>></textarea></td>
        </tr>
      </table>
      <br> <table width="80%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
        <tr align="center"> 
          <td colspan="4"  class="bluenav" bgcolor="#739FC4" ><strong>Final Exam 
            Application</strong></td>
        </tr>
        <tr align="center"> 
          <td width="37%" align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดเด่น</strong></p></td>
          <td width="63%" align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea7" cols="50" rows="6" class="pn-text"><? echo $row["final_comment1"];?></textarea></td>
        </tr>
        <tr align="center"> 
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดอ่อน</strong></p></td>
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea7" cols="50" rows="6" class="pn-text"><? echo $row["final_comment2"];?></textarea></td>
        </tr>
        <tr align="center"> 
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>ข้อควรปรับปรุง</strong></p></td>
          <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="textarea7" cols="50" rows="6" class="pn-text"><? echo $row["final_comment3"];?></textarea></td>
        </tr>
      </table></td>
  </tr>
</table>
<? 
		$color = 1;
		}
		$i++;
	}
}
?>
<br>
<table width="70%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
  <tr align="center"> 
    <td width="100%" bgcolor="#739FC4"  class="bluenav" ><input type="button"  value="B a c k" onClick="history.back();"></td>
  </tr>
</table>
<br>
<br>
</body>
</html>