<?
		require("../include/global_login.php");		// require("../include/global.php");
		include("./include/var.inc.php");
?>
<html>
<head>
<title>Result of e-Evaluation</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<meta name="Author" CONTENT="นางสาวชิดชนก วรรณกูล(MissChitchanok Wannakul)">
<meta name="keywords" content="Evaluation for M@xlearn / KU-LMS[ Kasetsart University Learning Management System ]">
<meta name="description" content="Evaluation for M@xlearn / KU-LMS[ Kasetsart University Learning Management System ] เป็นระบบประเมินการเรียนการสอนออนไลน์(ผ่านเครือข่ายคอมพิวเตอร์) มหาวิทยาลัยเกษตรศาสตร์ เน้นผู้เรียนเป็นศูนย์กลาง ผู้เรียนสามารถศึกษาและทบทวนบทเรียนได้ด้วยตนเอง">
<script language="JavaScript" src="./js/JUMPTOP.JS" type="text/javascript"></script>
<script language="Javascript" src="./js/mmopenwindow.js" type="text/javascript"></script>
<link href="./include/main.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="24" bgcolor="#004080" class="bwhite">&nbsp; ระบบประเมินการสอนของอาจารย์โดยนิสิต ( Teaching 
      Evaluate System :TES )</td>
  </tr>
  <tr> 
        <td height="24" bgcolor="#E9E9F3"> <b><a href="./index.php">Home</a>
	  | <a href="./cindex.php<? echo "?courses=$courses"; ?>">วิชา<?  
	   $sel_cname=mysql_query("SELECT c.* FROM courses as c WHERE c.id=$courses;");
	   $coursename=mysql_result($sel_cname,0,"name"); echo $coursename; ?></a><?	   
   	   $sel_start=mysql_query("SELECT start_date FROM eval_q_set as q_set WHERE q_set.q_set_id=$qset;");
	   $start_date=mysql_result($sel_start,0,"start_date");		
	   $today=date("Y-m-d H:i:s");	 
	   
      if($today<$start_date)
	  {	 ?>
      | <a href="./Add_usrdQ.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">เพิ่มคำถามจากผู้สอน</a> 
      <? }else{ ?>
      | <a href="./cresult.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ผลการประเมินแสดงคะแนนเฉลี่ย</a> 
      | <a href="./numstd.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ผลการประเมินแสดงจำนวนผู้ตอบ</a> 
      <?         }	 if(  ($totalstd-$std)>=1){ ?>
      | <a href="trackstd.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ตรวจสอบรายชื่อผู้ที่ยังไม่ได้ประเมิน</a>
      <? } ?>
	   | <a onClick="MM_openBrWindow('./report/eval_report.htm','','scrollbars=yes,width=800,height=600, resizeable=yes, statusbar=yes')" style="cursor:hand">ข้อมูลการประเมินย้อนหลัง</a></b> 
    </td>
  </tr>
</table>
<br>&nbsp;
 <?
 			$stdscrs=mysql_query("SELECT qset.* FROM eval_q_set as qset WHERE qset.q_set_id=$qset AND qset.current=1");
			$maxs=@mysql_result($stdscrs,0,"max_std_scr");
			$maxu=@mysql_result($stdscrs,0,"max_usrd_scr");
			$sums=@mysql_result($stdscrs,0,"sum_std_scr");
			$sumu=@mysql_result($stdscrs,0,"sum_usrd_scr");
			$std=@mysql_result($stdscrs,0,"no_eval_std");
			$std_id=@mysql_result($stdscrs,0,"std_eval_id");
			$usrd_id=@mysql_result($stdscrs,0,"usrd_eval_id");
			
			if($std_id!=""  && $std_id!=null)
			{ 		// START STD detail
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/left_bg.gif" style="<? echo $bottom.$top.$left.$right; ?>">
  <tr align="center" bgcolor="#E9E9F3"> 
    <td height="21" colspan="4" style="<? echo $bottom; ?>" align="left"><br>
      &nbsp; &nbsp; &nbsp; &nbsp; <? echo $navy; ?>คำถามมาตราฐาน<? echo $ctxt; ?><br> &nbsp; </td>
  </tr>
<?		
 	    $stdq=mysql_query("SELECT sum(s_ans.scores)/$std  as scrs,sq.* 
										  FROM eval_q_set as qset,eval_std_answers as s_ans,eval_std_questions as sq, 
													eval_std_group as sg, eval_check_c  as chc   
										  WHERE  qset.q_set_id=$qset AND chc.q_set_id=$qset  AND 
													s_ans.check_c_id=chc.check_c_id AND qset.std_eval_id=sg.std_eval_id  AND 
													sg.q_id=sq.q_id AND s_ans.q_id=sq.q_id AND sg.alt_id<>0
										  GROUP BY sg.alt_id, sg.q_id");
										  
		 $cntq=0;
		 $sq_num=@mysql_num_rows($stdq);
		 
		 if($sq_num<=0)
		 {		$scrs=0;
				$stdq=mysql_query("SELECT $scrs, sq.* 
												  FROM eval_q_set as qset,eval_std_questions as sq, eval_std_group as sg 
												  WHERE  qset.q_set_id=$qset  AND qset.std_eval_id=sg.std_eval_id  AND 
															sg.q_id=sq.q_id AND sg.alt_id<>0
												  GROUP BY sg.alt_id, sg.q_id");
		 }
?>  
  <tr align="center" bgcolor="#E9E9F3"> 
    <td height="21" style="<? echo $bottom.$right; ?>">&nbsp;<? echo $navy; ?>ข้อที่<? echo $ctxt; ?>&nbsp;</td>
    <td style="<? echo $bottom.$right; ?>">&nbsp;<? echo $navy; ?>คำถาม<? echo $ctxt; ?>&nbsp;</td>
    <td style="<? echo $bottom.$right; ?>">&nbsp;<? echo $navy; ?>คะแนนเต็ม&nbsp; <? echo $ctxt; ?></td>
    <td style="<? echo $bottom; ?>">&nbsp;<? echo $navy." คะแนนเฉลี่ย".$ctxt; ?>&nbsp;</td>
  </tr>
  <?
		 while($rowq=mysql_fetch_array($stdq))
		 {      $cntq++;
				 $scores=$rowq["scrs"];
				 $avgscr=number_format($scores, 2);
				 $max_scr=$rowq["max_scores"];
  ?>
  <tr align="center"> 
    <td height="21" style="<? echo $right; ?>">&nbsp; <? echo $cntq; ?></td>
    <td align="left" style="<? echo $right; ?>">&nbsp; <? echo $rowq["question"]; ?></td>
    <td align="center"  style="<? echo $right; ?>">&nbsp; <? echo $max_scr; ?>&nbsp;</td>
    <td align="left">&nbsp; <img src="./images/1.gif" width="<? $p_scr=$avgscr*100/$max_scr; echo $p_scr; ?>" height="10">&nbsp;<? echo $avgscr; ?></td>
  </tr>
  <?   }   // END WHILE 
  
 	    $std_q0=mysql_query("SELECT sq.* FROM eval_q_set as qset,eval_std_questions as sq,
													eval_std_group as sg
											WHERE  qset.q_set_id=$qset AND qset.std_eval_id=sg.std_eval_id  AND 
													sg.q_id=sq.q_id AND sg.alt_id=0 AND sq.max_scores=0
											ORDER BY sg.q_id");

			 while($rowq=mysql_fetch_array($std_q0))
			 {      $cntq++;
  ?>
  <tr align="center"> 
    <td height="21" style="<? echo $right; ?>">&nbsp; <? echo $cntq; ?></td>
    <td align="left" style="<? echo $right; ?>">&nbsp; <? echo $rowq["question"]; ?></td>
    <td align="left" style="<? echo $top; ?>" colspan="2"><? 
	
	$std_ans0=mysql_query("SELECT DISTINCT text_ans 	FROM eval_std_answers WHERE  q_set_id=$qset AND scores=0 ORDER BY q_id");
	$c_stxt=0;

			 while($row_stxt0=mysql_fetch_array($std_ans0))
			 {	 $c_stxt++;
			 		if($c_stxt==1){ $br="&nbsp;"; }else{ $br="<br>&nbsp;"; }
			 		echo "$br<img src=\"./images/bullet.gif\" width=\"11\" height=\"11\"> ".$row_stxt0["text_ans"]; 
			 }	?>&nbsp;</td>
  </tr>
  <? 
			}   // END while
  ?>
</table><? 
         }    		//  END STD detail  ?><br>&nbsp;
		 
<?
			if($usrd_id!=""  && $usrd_id!=null)
			{ 		//   START USRD detail
/*			
				  $usrdq=mysql_query("SELECT sum(u_ans.scores)/$std as scrs, uq.*  
				  									  FROM   eval_q_set as qset, eval_usrd_answers as u_ans, 
																	eval_usrd_questions as uq, eval_usrd_group as ug
													  WHERE   qset.q_set_id=$qset  AND qset.usrd_eval_id=ug.usrd_eval_id  AND 
													  				ug.q_id=uq.q_id AND u_ans.q_id=uq.q_id   AND ug.alt_id<>0
													  GROUP BY   ug.alt_id, ug.q_id;");  
				 $cntq2=0;
				 $uq_num=@mysql_num_rows($usrdq);
				 
				 if($uq_num<=0)
				 {		$scrs2=0;				 
						$usrdq=mysql_query("SELECT 0, uq.* FROM eval_q_set as qset,eval_usrd as eu,eval_usrd_GROUP as ug, eval_usrd_questions as uq WHERE qset.q_set_id=$qset AND qset.usrd_eval_id=eu.usrd_eval_id AND ug.usrd_eval_id=eu.usrd_eval_id AND ug.q_id=uq.q_id AND uq.alt_id>2 ORDER BY ug.q_id;");														  														  
				 }
*/		
	  $usrdq=mysql_query("SELECT ug.g_id, ug.order_no, ua.*, uq.* FROM eval_q_set as qset,eval_usrd as eu,eval_usrd_GROUP as ug, eval_usrd_questions as uq, eval_usrd_alternatives as ua  WHERE qset.q_set_id=$qset AND ug.usrd_eval_id=qset.usrd_eval_id AND ug.q_id=uq.q_id AND uq.alt_id=ua.alt_id GROUP BY ug.g_id ORDER BY ug.order_no");		 
	  $cnt=0;
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/left_bg.gif" style="<? echo $bottom.$top.$left.$right; ?>">
  <tr align="center" bgcolor="#E9E9F3"> 
    <td height="21" colspan="4" style="<? echo $bottom; ?>" align="left"><br> &nbsp; &nbsp; 
      &nbsp; &nbsp; <? echo $navy; ?>คำถามจากผู้สอน<? echo $ctxt; ?><br> &nbsp; </td>
  </tr>
  <tr align="center" bgcolor="#E9E9F3"> 
    <td height="21" style="<? echo $bottom.$right; ?>">&nbsp;<? echo $navy; ?>ข้อที่<? echo $ctxt; ?>&nbsp;</td>
    <td style="<? echo $bottom.$right; ?>">&nbsp;<? echo $navy; ?>คำถาม<? echo $ctxt; ?>&nbsp;</td>
    <td style="<? echo $bottom.$right; ?>">&nbsp;<? echo $navy; ?>คะแนนเต็ม<? echo $ctxt; ?>&nbsp;</td>
    <td style="<? echo $bottom; ?>">&nbsp;<? echo $navy."คะแนนเฉลี่ย".$ctxt; ?>&nbsp;</td>
  </tr>
  <?
/*  
		 while($rowq2=mysql_fetch_array($usrdq))
		 {      $cntq2++;
				 $scores2=$rowq2["scrs"];
				 $avgscr2=number_format($scores2, 2);
 				 $max_scr=$rowq2["max_scores"];
  */
  		 while($rowq2=mysql_fetch_array($usrdq))
		 {      $cnt++;
  ?>
  <tr align="center"> 
    <td height="21" style="<? echo $right; ?>">&nbsp; <? echo $cntq2; ?></td>
    <td align="left" style="<? echo $right; ?>">&nbsp; <? echo $rowq2["question"]; ?></td>
	<?
		   if($rowq2["alt_id"]>2){
	?>	
    <td align="center" style="<? echo $right; ?>">&nbsp; <? echo  $rowq2["max_scores"]; ?>&nbsp;</td>
    <td align="left">&nbsp; <img src="./images/1.gif" width="<? $p_scr=$avgscr2*100/$max_scr; echo $p_scr; ?>" height="10">&nbsp;<? echo $avgscr2; ?>&nbsp;</td>
  <?
    		}elseif($rowq2["alt_id"]==1){     // END WHILE
   ?>
	 <td align="left" style="<? echo $top; ?>" colspan="2"><? echo "$br<img src=\"./images/bullet.gif\" width=\"11\" height=\"11\">  ".$row_utxt0["text_ans"]."&nbsp;"; ?></td>
   <? 	   	   }elseif( $rowq2["alt_id"]==2 ){ ?><td align="left" style="<? echo $top; ?>" colspan="2">&nbsp;</td><? } ?>
  </tr>	 
  <tr align="center"> 
    <td height="21" style="<? echo $right; ?>">&nbsp; <? echo $cntq2; ?></td>
    <td align="left" style="<? echo $right; ?>">&nbsp; <? echo $rowq["question"]; ?></td>
    <td align="left" style="<? echo $top; ?>" colspan="2"><? 
	
	$usrd_ans0=mysql_query("SELECT DISTINCT uans.text_ans	FROM eval_usrd_answers uans WHERE  uans.q_set_id=$qset AND uans.scores=0 AND uans.q_id=".$rowq["q_id"]."  ORDER BY q_id");
	$c_utxt=0;
			 while($row_utxt0=mysql_fetch_array($usrd_ans0))
			 {	    $c_utxt++;
			 		if($c_utxt==1){ $br="&nbsp;"; }else{ $br="<br>&nbsp;"; }
			 		echo "$br<img src=\"./images/bullet.gif\" width=\"11\" height=\"11\">  ".$row_utxt0["text_ans"]; 
			 }	?>&nbsp;</td>
  </tr>
  <? 
			}   // END while
  ?>
</table><? 
         }   //  END USRD detail    ?><br>&nbsp;

<?
        $selcomment=mysql_query("SELECT es.comment as s_comment,eu.comment  as u_comment
	                                                            FROM eval_check_c as chc,eval_std as es,eval_usrd as eu,eval_q_set as qset
	   															WHERE chc.q_set_id=$qset AND qset.q_set_id=$qset AND qset.std_eval_id=es.std_eval_id AND
																qset.usrd_eval_id=eu.usrd_eval_id  ORDER BY chc.check_c_id ;");

		$sel_ans=mysql_query("SELECT chc.check_c_id as chcid, chc.comment_ans FROM  eval_check_c as chc WHERE chc.q_set_id=$qset AND chc.status=1");
		
	   $s_comment=@mysql_result($selcomment,0,"s_comment");
	   $u_comment=@mysql_result($selcomment,0,"u_comment");
 ?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/left_bg.gif" style="<? echo $bottom.$top.$left.$right; ?>">
  <tr> 
    <td width="45%" align="right" valign="top" style="<? echo $right; ?>"><br><? echo $navy; ?><? echo  $s_comment." &nbsp; ".$u_comment; ?><? echo $ctxt; ?> &nbsp; </td>
    <td><?		$c_txt=0;
		while( $rowz=mysql_fetch_array($sel_ans))
		{  		$c_txt++;   if($c_txt==1){ $br="&nbsp;"; }else{ $br="<br>&nbsp;"; }
		 		echo "$br<img src=\"./images/bullet.gif\" width=\"11\" height=\"11\"> ".$rowz["comment_ans"].""; 
		 } ?>&nbsp;</td>
  </tr>
</table>
<br><center>	<input type="button" name="Button" value="Back" onClick="javascript: history.back();"></center><br> 
</body>
</html>