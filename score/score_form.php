<?   
	require("../include/global_login.php");
	$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
	$user_name = @mysql_result($users,0,"firstname")."  ".@mysql_result($users,0,"surname");
	$users_belong=mysql_query("SELECT * from users WHERE id=".$belong);
	$uname_belong = @mysql_result($users_belong,0,"firstname")."  ".@mysql_result($users_belong,0,"surname");
	
	if($person["category"]==2){
		$eval = mysql_query("SELECT * FROM evaluate WHERE eval_owner=$belong AND eval_by=".$person["id"].";");
		//$row_eval = mysql_fetch_array($eval);
		if (mysql_num_rows($eval) != 0) {
			$rh_score1 = @mysql_result($eval,0,"home_score1");
			$rh_score2 = @mysql_result($eval,0,"home_score2");
			$rh_score3 = @mysql_result($eval,0,"home_score3");
			$rh_com1 = @mysql_result($eval,0,"home_comment1");
			$rh_com2 = @mysql_result($eval,0,"home_comment2");
			$rh_com3 = @mysql_result($eval,0,"home_comment3");
			$rf_score1 = @mysql_result($eval,0,"final_score1");
			$rf_score2 = @mysql_result($eval,0,"final_score2");
			$rf_score3 = @mysql_result($eval,0,"final_score3");
			$rf_com1 = @mysql_result($eval,0,"final_comment1");
			$rf_com2 = @mysql_result($eval,0,"final_comment2");
			$rf_com3 = @mysql_result($eval,0,"final_comment3");		
			$update = 1;
		} else {
			$update = 0;
		}
		
	}
	
	if (($Submit) && ($h_com1!="") &&($h_com2!="")&&($h_com3!="")&&($f_com1!="")&&($f_com2!="")&&($f_com3!=""))
	{
		
		if ($update == 0) {
			$sql = "INSERT INTO evaluate VALUES ($belong, ".$person["id"].", $h_score1, $h_score2, $h_score3, '".$h_com1."', '".$h_com2."', '".$h_com2."',
							$f_score1, $f_score2, $f_score2, '".$f_com1."', '".$f_com2."', '".$f_com2."');";		
			mysql_query($sql);
		}
		else {
			$sql = "UPDATE evaluate SET home_score1 = $h_score1, home_score2 = $h_score2, home_score3 = $h_score3, 
							home_comment1 = '".$h_com1."', home_comment2 = '".$h_com2 ."', home_comment3 = '".$h_com3."', 
							final_score1 = $f_score1, final_score2 = $f_score2, final_score3 = $f_score3,
							final_comment1 = '".$f_com1."', final_comment2 = '".$f_com2."', final_comment3 = '".$f_com3."' 
							WHERE eval_owner=$belong AND eval_by=".$person["id"].";";
			//echo $sql;
			mysql_query($sql);
		}
		
		$sql_up = "UPDATE evaluate_match SET status = 0 WHERE eval_owner=$belong AND eval_by=".$person["id"].";";
		//echo $sql_up;
		mysql_query($sql_up);
		header("Location: index.php?courses=$courses");
	}
	
?>
<html>
<head>
        <title>Exam Evaluate</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<SCRIPT language="JavaScript">
<!-- 
function validate(_frm) { 

	var _f="Here is the form data you entered:";
	var _l="Do you want to submit this data?";
	var errormsg='Following Errors Occured ::\n_____________________________\n\n';
	var _n="\n";
    var _fd="";
	var error_h1=false;
	var error_h2=false;
	var error_h3=false;
	var error_f1=false;
	var error_f2=false;
	var error_f3=false;
	var error;
		
		if (_frm.h_com1.value == "" )
			{		
					errormsg+='Please enter Homework Advantage Point.\n';
					error_h1=true;						
			}
		if (_frm.h_com2.value == "" )
			{		
					errormsg+='Please enter Homework Weak Point.\n';
					error_h2=true;				
			}	
		if (_frm.h_com3.value == "" )
			{		
					errormsg+='Please enter Homework Suggestion.\n';
					error_h3=true;		
			}
		if (_frm.f_com1.value == "" )
			{		
					errormsg+='Please enter Final Advantage Point.\n';
					error_f1=true;
			}	
		if (_frm.f_com2.value == "" )
			{		
					errormsg+='Please enter Final Weak Point.\n';
					error_f2=true;
			}
		if (_frm.f_com3.value == "" )
			{		
					errormsg+='Please enter Final Suggestion.\n';
					error_f3=true;	
			}
			
		if(error_h1||error_h2||error_h3||error_f1||error_f2||error_f3)
			{
				error=true;
			}
				else
			{
				error=false;
			}
			
	if (error)
	{
		alert(errormsg);
		return false;
	} else {
		_fd += "Homework Score :::  ภาพรวมของ Web ทั้งหมด:  " + _frm.h_score1.value  +" คะแนน" + _n;
		_fd += "Homework Score ::: Webboard และ Address Book   " + _frm.h_score2.value   + " คะแนน"+ _n;
		_fd += "Homework Score ::: ความสามารถพิเศษอื่นๆ:   " + _frm.h_score3.value   + " คะแนน"+ _n;
		_fd +=   _n;
		_fd += "Final Score :::  ภาพรวมของ Web ทั้งหมด:   " + _frm.f_score1.value   + " คะแนน"+ _n;
		_fd += "Final Score :::  การใช้งานของ Application:   " + _frm.f_score2.value   + " คะแนน"+ _n;
		_fd += "Final Score :::  ความสามารถพิเศษอื่น ๆ:   " + _frm.f_score3.value   + " คะแนน"+ _n;
		return confirm(_f+_n+_n+_fd+_n+_l);
	}
} 
//--> 
</SCRIPT> 


<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<form name="score_form" method="post" action="score_form.php" onSubmit="return validate(document.score_form)">
  <table width="70%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
    <tr align="center"> 
      <td width="100%" bgcolor="#739FC4"  class="bluenav" ><strong><font size="5">:-: 
        Exam Evaluation :-:</font></strong></td>
    </tr>
  </table>
  <br>
  <table width="70%" border="0" align="center">
    <tr align="center"> 
      <td width="50%" bgcolor="#739FC4"  class="mini" ><strong>::: ผู้ประเมิน 
        ::: </strong></td>
      <td width="50%" bgcolor="#739FC4"  class="mini" ><strong>::: ผู้ถูกประเมิน 
        ::: </strong></td>
    </tr>
    <tr align="center">
      <td  width="50%" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;" class="mini"><? echo $user_name;?></td>
      <td  width="50%" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;" class="mini"><? echo $uname_belong;?></td>
    </tr>
  </table>
  <br>
  <table width="70%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
    <tr align="center"> 
      <td colspan="4"  class="mini" bgcolor="#739FC4" ><strong>Homework Application</strong></td>
    </tr>
    <tr align="center" > 
      <td  width="37%" align="left" class="mini"  style="border-bottom: dotted #2D649B 1px;"><p><strong>1. 
          ภาพรวมของ Web ทั้งหมด</strong><br>
          - User friendly<br>
          - ความสวยงาม<br>
          - ออกแบบได้อย่างเหมาะสม<br>
          <strong><font color="#FF0000">(10 คะแนน)</font> </strong><br>
        </p></td>
      <td width="63%" align="left"  class="mini"  style="border-bottom: dotted #2D649B 1px;"> 
        <select name="h_score1" class="pn-text">
          <option value="0" <? if ($rh_score1 == '0') { echo "selected";}?>>0</option>
          <option value="1" <? if ($rh_score1 == '1') { echo "selected";}?>>1</option>
          <option value="2" <? if ($rh_score1 == '2') { echo "selected";}?>>2</option>
          <option value="3" <? if ($rh_score1 == '3') { echo "selected";}?>>3</option>
          <option value="4" <? if ($rh_score1 == '4') { echo "selected";}?>>4</option>
          <option value="5" <? if ($rh_score1 == '5') { echo "selected";}?>>5</option>
          <option value="6" <? if ($rh_score1 == '6') { echo "selected";}?>>6</option>
          <option value="7" <? if ($rh_score1 == '7') { echo "selected";}?>>7</option>
          <option value="8" <? if ($rh_score1 == '8') { echo "selected";}?>>8</option>
          <option value="9" <? if ($rh_score1 == '9') { echo "selected";}?>>9</option>
          <option value="10" <? if ($rh_score1 == '10') { echo "selected";}?>>10</option>
        </select>
        คะแนน</td>
    </tr>
    <tr align="center"> 
      <td width="37%" align="left" class="mini"  style="border-bottom: dotted #2D649B 1px;"><p> 
          <strong>2. Webboard และ Address Book <br>
          - </strong>ใช้งานได้จริง<strong><br>
          - </strong>ไม่มี Error<br>
          <strong><font color="#FF0000">(10 คะแนน) </font></strong></p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"> 
        <select name="h_score2" class="pn-text">
                   <option value="0" <? if ($rh_score2 == '0') { echo "selected";}?>>0</option>
				  <option value="1" <? if ($rh_score2 == '1') { echo "selected";}?>>1</option>
				  <option value="2" <? if ($rh_score2 == '2') { echo "selected";}?>>2</option>
				  <option value="3" <? if ($rh_score2 == '3') { echo "selected";}?>>3</option>
				  <option value="4" <? if ($rh_score2 == '4') { echo "selected";}?>>4</option>
				  <option value="5" <? if ($rh_score2 == '5') { echo "selected";}?>>5</option>
				  <option value="6" <? if ($rh_score2 == '6') { echo "selected";}?>>6</option>
				  <option value="7" <? if ($rh_score2 == '7') { echo "selected";}?>>7</option>
				  <option value="8" <? if ($rh_score2 == '8') { echo "selected";}?>>8</option>
				  <option value="9" <? if ($rh_score2 == '9') { echo "selected";}?>>9</option>
				  <option value="10" <? if ($rh_score2 == '10') { echo "selected";}?>>10</option>
        </select>
        คะแนน</td>
    </tr>
    <tr align="center"> 
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>3. 
          ความสามารถพิเศษอื่น ๆ</strong> <br>
          - Validation (JavaScript)<br>
          - Flash Animation<br>
          - ความคิดสร้างสรรที่แตกต่างจากคนอื่น<br>
          <strong><font color="#FF0000">(10 คะแนน)</font></strong> </p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"> 
        <select name="h_score3" class="pn-text">
           		  <option value="0" <? if ($rh_score3 == '0') { echo "selected";}?>>0</option>
				  <option value="1" <? if ($rh_score3 == '1') { echo "selected";}?>>1</option>
				  <option value="2" <? if ($rh_score3 == '2') { echo "selected";}?>>2</option>
				  <option value="3" <? if ($rh_score3 == '3') { echo "selected";}?>>3</option>
				  <option value="4" <? if ($rh_score3 == '4') { echo "selected";}?>>4</option>
				  <option value="5" <? if ($rh_score3 == '5') { echo "selected";}?>>5</option>
				  <option value="6" <? if ($rh_score3 == '6') { echo "selected";}?>>6</option>
				  <option value="7" <? if ($rh_score3 == '7') { echo "selected";}?>>7</option>
				  <option value="8" <? if ($rh_score3 == '8') { echo "selected";}?>>8</option>
				  <option value="9" <? if ($rh_score3 == '9') { echo "selected";}?>>9</option>
				  <option value="10" <? if ($rh_score3 == '10') { echo "selected";}?>>10</option>
        </select>
        คะแนน</td>
    </tr>
    <tr align="center"> 
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดเด่น 
          (Homework Advantage Point) </strong></p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="h_com1" cols="50" rows="6" class="pn-text"><? echo $rh_com1;?></textarea></td>
    </tr>
    <tr align="center"> 
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดอ่อน 
          (Homework Weak Point) </strong></p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="h_com2" cols="50" rows="6" class="pn-text"><? echo $rh_com2;?></textarea></td>
    </tr>
    <tr align="center"> 
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>ข้อควรปรับปรุง 
          <br>
          (Homework Suggestion)</strong></p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="h_com3" cols="50" rows="6" class="pn-text"><? echo $rh_com3;?></textarea></td>
    </tr>
  </table>
  <br>
  <table width="70%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
    <tr align="center"> 
      <td colspan="4"  class="mini" bgcolor="#739FC4" ><strong>Final Exam Application</strong></td>
    </tr>
    <tr align="center"> 
      <td  width="37%" align="left"  class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>1. 
          ภาพรวมของ Web ทั้งหมด</strong><br>
          - User friendly<br>
          - ความสวยงาม<br>
          - ออกแบบได้อย่างเหมาะสม<br>
          <strong><font color="#FF0000">(10 คะแนน)</font> </strong></p></td>
      <td width="63%" align="left"  class="mini" style="border-bottom: dotted #2D649B 1px;">
	  	<select name="f_score1" class="pn-text">
			<option value="0" <? if ($rf_score1 == '0') { echo "selected";}?>>0</option>
          	<option value="1" <? if ($rf_score1 == '1') { echo "selected";}?>>1</option>
          	<option value="2" <? if ($rf_score1 == '2') { echo "selected";}?>>2</option>
          	<option value="3" <? if ($rf_score1 == '3') { echo "selected";}?>>3</option>
          	<option value="4" <? if ($rf_score1 == '4') { echo "selected";}?>>4</option>
          	<option value="5" <? if ($rf_score1 == '5') { echo "selected";}?>>5</option>
          	<option value="6" <? if ($rf_score1 == '6') { echo "selected";}?>>6</option>
          	<option value="7" <? if ($rf_score1 == '7') { echo "selected";}?>>7</option>
          	<option value="8" <? if ($rf_score1 == '8') { echo "selected";}?>>8</option>
          	<option value="9" <? if ($rf_score1 == '9') { echo "selected";}?>>9</option>
          	<option value="10" <? if ($rf_score1 == '10') { echo "selected";}?>>10</option>
        </select>
        คะแนน</td>
    </tr>
    <tr align="center"> 
      <td width="37%" align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>2. 
          การใช้งานของ Application</strong><strong><br>
          - </strong>ทำครบถ้วนตามโจทย์ที่ตั้งไว้<strong><br>
          - </strong>ใช้งานได้จริง<strong><br>
          - </strong>ไม่มี Error<br>
          <strong><font color="#FF0000">(10 คะแนน) </font></strong></p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;">
	  	<select name="f_score2" class="pn-text">
				  <option value="0" <? if ($rf_score2 == '0') { echo "selected";}?>>0</option>
				  <option value="1" <? if ($rf_score2 == '1') { echo "selected";}?>>1</option>
				  <option value="2" <? if ($rf_score2 == '2') { echo "selected";}?>>2</option>
				  <option value="3" <? if ($rf_score2 == '3') { echo "selected";}?>>3</option>
				  <option value="4" <? if ($rf_score2 == '4') { echo "selected";}?>>4</option>
				  <option value="5" <? if ($rf_score2 == '5') { echo "selected";}?>>5</option>
				  <option value="6" <? if ($rf_score2 == '6') { echo "selected";}?>>6</option>
				  <option value="7" <? if ($rf_score2 == '7') { echo "selected";}?>>7</option>
				  <option value="8" <? if ($rf_score2 == '8') { echo "selected";}?>>8</option>
				  <option value="9" <? if ($rf_score2 == '9') { echo "selected";}?>>9</option>
				  <option value="10" <? if ($rf_score2 == '10') { echo "selected";}?>>10</option>				  
        </select>
        คะแนน </td>
    </tr>
    <tr align="center"> 
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>3. 
          ความสามารถพิเศษอื่น ๆ</strong> <br>
          - Validation (JavaScript)<br>
          - Flash Animation<br>
          - ความคิดสร้างสรรที่แตกต่างจากคนอื่น<br>
          <strong><font color="#FF0000">(10 คะแนน)</font></strong> </p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;">
	  	<select name="f_score3" class="pn-text">
				  <option value="0" <? if ($rf_score3 == '0') { echo "selected";}?>>0</option>
				  <option value="1" <? if ($rf_score3 == '1') { echo "selected";}?>>1</option>
				  <option value="2" <? if ($rf_score3 == '2') { echo "selected";}?>>2</option>
				  <option value="3" <? if ($rf_score3 == '3') { echo "selected";}?>>3</option>
				  <option value="4" <? if ($rf_score3 == '4') { echo "selected";}?>>4</option>
				  <option value="5" <? if ($rf_score3 == '5') { echo "selected";}?>>5</option>
				  <option value="6" <? if ($rf_score3 == '6') { echo "selected";}?>>6</option>
				  <option value="7" <? if ($rf_score3 == '7') { echo "selected";}?>>7</option>
				  <option value="8" <? if ($rf_score3 == '8') { echo "selected";}?>>8</option>
				  <option value="9" <? if ($rf_score3 == '9') { echo "selected";}?>>9</option>
				  <option value="10" <? if ($rf_score3 == '10') { echo "selected";}?>>10</option>
        </select>
        คะแนน </td>
    </tr>
    <tr align="center"> 
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดเด่น 
          (Final Advantage Point) </strong></p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="f_com1" cols="50" rows="6" class="pn-text"><? echo $rf_com1;?></textarea></td>
    </tr>
    <tr align="center"> 
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>จุดอ่อน 
          (Final Advantage Point) </strong></p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="f_com2" cols="50" rows="6" class="pn-text"><? echo $rf_com2;?></textarea></td>
    </tr>
    <tr align="center"> 
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><p><strong>ข้อควรปรับปรุง 
          (Final Suggestion) </strong></p></td>
      <td align="left" class="mini" style="border-bottom: dotted #2D649B 1px;"><textarea name="f_com3" cols="50" rows="6" class="pn-text"><? echo $rf_com3;?></textarea></td>
    </tr>
  </table>
  <br>
  <table width="70%" border="0" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
    <tr align="center"> 
      <td width="100%" bgcolor="#739FC4"  class="bluenav" >
	  	<input type="submit" name="Submit" value="Submit">
        <input type="reset" name="Submit2" value="Reset">
        <input type="hidden" name="belong" value="<? echo $belong;?>">
        <input type="hidden" name="courses" value="<? echo $courses;?>"></td>
    </tr>
  </table>
</form>
</body>
</html>