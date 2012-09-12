<?
		require("../include/global_login.php");		// require("../include/global.php");
		include("./include/numstd_scr.inc.php");
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
    <td height="24" bgcolor="#E9E9F3">  <b><a href="./index.php">Home</a>
	  | <a href="./cindex.php<? echo "?courses=$courses"; ?>">วิชา<?  
	   $sel_cname=mysql_query("SELECT c.* FROM courses as c WHERE c.id=$courses;");
	   $coursename=mysql_result($sel_cname,0,"name"); echo $coursename; ?></a><?
	   
		   $start_date=$row["start_date"];		$today=date("Y-m-d H:i:s");	   
     if($today<$start_date){	?>
      | <a href="./Add_usrdQ.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">เพิ่มคำถามจากผู้สอน</a> 
      <? }else{ ?>
      | <a href="./cresult.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ผลการประเมินแสดงคะแนนเฉลี่ย</a> 
      | <a href="./numstd.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ผลการประเมินแสดงจำนวนผู้ตอบ</a> 
      <?   }	 if(  ($totalstd-$std)>=1){ ?>
      | <a href="trackstd.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ตรวจสอบรายชื่อผู้ที่ยังไม่ได้ประเมิน</a>
      <? } ?>
	   | <a onClick="MM_openBrWindow('./report/eval_report.htm','','scrollbars=yes,width=800,height=600, resizeable=yes, statusbar=yes')" style="cursor:hand">ข้อมูลการประเมินย้อนหลัง</a></b> 
    </td>
  </tr>
</table>
<!--
  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/left_bg.gif" style="<? echo $top.$left.$right.$bottom; ?>">
<?
	 $detail=mysql_query("SELECT c.*, qset.start_date, qset.end_date, qset.std_eval_id as es, qset.usrd_eval_id as eu  FROM eval_q_set  as qset, courses as c WHERE c.id=$courses AND c.id=qset.courses_id AND qset.q_set_id=$qset  AND qset.current=1;");

		while($roww=@mysql_fetch_array($detail)){
?>
    <tr align="center"> 
      <td colspan="7" style="<? echo  $bottom; ?>"><br><? echo $navyO."รายวิชา ".$roww["name"]." ".$roww["fullname"]; 			
	     if($roww["fullname_eng"]!="" && $roww["fullname_eng"]!=null)  echo "  (".$roww["fullname_eng"].") ";   
		 if($roww["section"]!="" && $roww["section"]!=null)   echo  "  หมู่ (".$roww["section"].")"; 
		  echo  "<br>  เริ่มวันที่ :".$roww["start_date"]." สิ้นสุดวันที่ :".$roww["end_date"].$navyC; ?><br>&nbsp;</td>
    </tr>
	<tr><td colspan="7"><br>&nbsp;  &nbsp;  &nbsp; &nbsp; <? echo $navyO; ?>ประเภทของแบบประเมิน : 
	         <? 
				  if( $roww["eu"]!="" && $roww["eu"]!=null  &&  $roww["es"]!="" && $roww["es"]!=null ){
							echo "แบบประเมินมาตราฐานและแบบประเมินจากผู้สอน";
					}else if(  ( $roww["eu"]!="" && $roww["eu"]!=null )   &&   ( $roww["es"]=="" || $roww["es"]==null )  ){
											echo "แบบประเมินจากผู้สอน";
					              }else if( ( $roww["eu"]=="" || $roww["eu"]==null )   &&   ( $roww["es"]!="" && $roww["es"]!=null )  ){
								  					    echo "แบบประเมินมาตราฐาน"; 			
											    }else{   echo "";   }   echo $navyC; 
			   ?><br>&nbsp; </td>
	</tr>
<?          }			 // END WHILE ($roww)   	?>
  </table>
-->  
  <br>&nbsp; 
<?
	   $selstd=mysql_query("SELECT  sq.*, sa.*  FROM  eval_q_set as qset,eval_std as es,eval_std_group as sg,eval_std_questions as sq, eval_std_alternatives as sa   WHERE   qset.q_set_id=$qset  AND qset.std_eval_id=es.std_eval_id AND sg.std_eval_id=qset.std_eval_id AND sg.q_id=sq.q_id AND sg.alt_id=sa.alt_id   ORDER BY  sg.alt_id,sg.q_id;");
													 													 
	   $std=mysql_query("SELECT s_ans.q_id,s_ans.scores, count(s_ans.scores) as numstd FROM eval_std_answers as s_ans,eval_check_c as chc 	WHERE chc.courses_id=$courses AND chc.q_set_id=$qset AND s_ans.check_c_id =chc.check_c_id  GROUP BY s_ans.scores, s_ans.q_id;");
												
	  /* 
	  $sumstd=mysql_query("SELECT s_ans.q_id,s_ans.scores, count(s_ans.scores) as numstd 	FROM eval_std_answers as s_ans,eval_check_c as chc  	WHERE chc.courses_id=$courses AND chc.q_set_id=$qset AND s_ans.check_c_id =chc.check_c_id   GROUP BY s_ans.scores;"); 
	   */
									
		$num_std = array();
		
		while ($row=mysql_fetch_array($std))
		{
			array_push($num_std,$row);
		}
		 // print_r($num_std); exit();

		if(@mysql_num_rows($selstd)>=1)
		{    			/// START  IF   eval_std_details 
?>
<table background="images/left_bg.gif" width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="<? echo $top.$left.$right.$bottom; ?>">
  <tr> 
    <td colspan="7" style="<? echo  $bottom; ?>"><br> &nbsp; &nbsp; 
      &nbsp; &nbsp; <? echo $navyO; ?>คำถามมาตราฐาน<? echo $navyC; ?><div align="right"><b>หน่วย 
        : คน</b>&nbsp; </div></td>
  </tr>
  <tr align="center" bgcolor="#E9E9F3"> 
    <td style="<? echo $right; ?>">&nbsp;<? echo $navyO; ?>ข้อที่<? echo $navyC; ?>&nbsp;</td>
    <td style="<? echo $right; ?>">&nbsp;<? echo $navyO; ?>คำถาม<? echo $navyC; ?>&nbsp;</td>
    <td height="21" colspan="5">&nbsp;<? echo $navyO; ?>ระดับการประเมิน(คะแนน)<? echo $navyC; ?>&nbsp;</td>
  </tr>
  <?    
             $cnt=0; $c1=0; $alt_txt=""; $a_std=array(0,0,0,0,0);
			 
  		 		while($rowans=mysql_fetch_array($selstd))
				{   
							$cnt++;  
							$c1++;

				 if($c1%2==0)
							$bgcolor="#EAEAFF";
				 else 
							$bgcolor="";					

  		 if($alt_txt!=$rowans["alt_id"]  && $alt_txt==""){ 		  $alt_txt=$rowans["alt_id"];    
  ?>
  <tr align="center" bgcolor="#E9E9F3"> 
    <td height="21" style="<? echo $right.$bottom; ?>">&nbsp;</td>
    <td align="left" style="<? echo $right.$bottom; ?>">&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans["alt1"]."(".$rowans["res1"].")".$navyC; ?></td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans["alt2"]."(".$rowans["res2"].")".$navyC; ?></td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans["alt3"]."(".$rowans["res3"].")".$navyC; ?></td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans["alt4"]."(".$rowans["res4"].")".$navyC; ?></td>
    <td style="<? echo $top.$bottom; ?>"><? echo $navyO.$rowans["alt5"]."(".$rowans["res5"].")".$navyC; ?></td>
  </tr>
  <? 
  			  }elseif($alt_txt!=$rowans["alt_id"]){  	    
	  
	  // $sumstd=mysql_query("SELECT s_ans.scores, count(s_ans.scores) as sumstd    FROM eval_std_answers as s_ans,eval_check_c as chc WHERE chc.courses_id=$courses AND chc.q_set_id=$qset AND s_ans.check_c_id =chc.check_c_id   GROUP BY s_ans.scores ;"); 
  ?>
  <tr align="center"> 
    <td height="21" colspan="2"  style="<? echo $top.$right; ?>" align="right"><b>รวม</b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><? echo $a_std[0]; $a_std[0]=0;  ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  echo $a_std[1]; $a_std[1]=0; ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  echo $a_std[2];  $a_std[2]=0; ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  echo $a_std[3]; $a_std[3]=0;  ?></b>&nbsp;</td>
    <td  style="<? echo $top; ?>"><b><?  echo $a_std[4]; $a_std[4]=0; ?></b>&nbsp;</td>
  </tr>
  <tr align="center" bgcolor="#E9E9F3"> 
    <td height="21" style="<? echo $top.$bottom; ?>">&nbsp;</td>
    <td align="left" style="<? echo $top.$right.$bottom; ?>">&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans["alt1"]."(".$rowans["res1"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans["alt2"]."(".$rowans["res2"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans["alt3"]."(".$rowans["res3"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans["alt4"]."(".$rowans["res4"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$bottom; ?>"><? echo $navyO.$rowans["alt5"]."(".$rowans["res5"].")".$navyC; ?>&nbsp;&nbsp;</td>
  </tr>
<?
					}
  ?>
  <tr align="center"> 
    <td bgcolor="<? echo $bgcolor; ?>" height="21" style="<? echo $right; ?>">&nbsp;<? echo $cnt; ?></td>
    <td bgcolor="<? echo $bgcolor; ?>" align="left" style="<? echo $right; ?>">&nbsp; <? echo $rowans["question"]; ?></td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $right; ?>"><? 
	  		$tmp= Get_Value_from_array2($rowans["q_id"],$rowans["res1"],$num_std,'q_id','scores','numstd');
	  		$a_std[0]+=$tmp;
			echo $tmp;
 	  ?>&nbsp; </td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $right; ?>">
      <?
	  		$tmp=Get_Value_from_array2($rowans["q_id"],$rowans["res2"],$num_std,'q_id','scores','numstd');
	  		$a_std[1]+=$tmp;
			echo $tmp;
	  ?>&nbsp; 
    </td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $right; ?>">
      <?
	  		$tmp= Get_Value_from_array2($rowans["q_id"],$rowans["res3"],$num_std,'q_id','scores','numstd');
	  		$a_std[2]+=$tmp;
			echo $tmp;
	  ?>&nbsp; 
    </td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $right; ?>">
      <?
	  		$tmp=  Get_Value_from_array2($rowans["q_id"],$rowans["res4"],$num_std,'q_id','scores','numstd');
	  		$a_std[3]+=$tmp;
			echo $tmp;
	  ?>&nbsp; 
    </td>
    <td bgcolor="<? echo $bgcolor; ?>">
      <?
	  		$tmp=  Get_Value_from_array2($rowans["q_id"],$rowans["res5"],$num_std,'q_id','scores','numstd');
	  		$a_std[3]+=$tmp;
			echo $tmp;
	  ?>&nbsp; 
    </td>
  </tr>
  <?
   	  	 }     // END WHILE        
  ?>
  <tr align="center"> 
    <td height="21" colspan="2"  style="<? echo $top.$right; ?>" align="right"><b>รวม</b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><? 
		echo $a_std[0]; $a_std[0]=0;  ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  
		echo $a_std[1]; $a_std[1]=0;    ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  
		echo $a_std[2];  $a_std[2]=0;   ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  
		echo $a_std[3]; $a_std[3]=0;  ?></b>&nbsp;</td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $top; ?>"><b><?  
		echo $a_std[4]; $a_std[4]=0;   ?></b>&nbsp;</td>
  </tr>
  <?
   	    $std_q0=mysql_query("SELECT sq.* FROM eval_q_set as qset,eval_std_questions as sq,
													eval_std_group as sg
											WHERE  qset.q_set_id=$qset AND qset.std_eval_id=sg.std_eval_id  AND 
													sg.q_id=sq.q_id AND sg.alt_id=0 AND sq.max_scores=0
											ORDER BY sg.q_id");

			 while($rowq=mysql_fetch_array($std_q0))
			 {      $cnt++;
  ?>
  <tr>
  	<td height="21" style="<? echo $top.$right; ?>" align="center"><? echo $cnt; ?></td>
  	<td style="<? echo $top.$right; ?>" align="left"><? echo $rowq["question"]; ?></td>
  	<td colspan="5" style="<? echo $top; ?>" align="left"><? 
		$std_ans0=mysql_query("SELECT DISTINCT text_ans	FROM eval_std_answers WHERE  q_set_id=$qset AND scores=0 ORDER BY q_id");
		$c_stxt=0;
		
		 while($row_stxt0=mysql_fetch_array($std_ans0))
		 {	 $c_stxt++;
				if($c_stxt==1){ $br="&nbsp;"; }else{ $br="<br>&nbsp;"; }
				echo "$br<img src=\"./images/bullet.gif\" width=\"11\" height=\"11\"> ".$row_stxt0["text_ans"]; 
		 }	?>&nbsp;</td>
  </tr>
  <? 			}   // END while  ?>
</table>
<?
      }  	// END IF   eval_std_details  ?><br>&nbsp; 
  <? 
	   $selusrd=mysql_query("SELECT  uq.*, ua.*     FROM   eval_q_set as qset,eval_usrd as eu,eval_usrd_group as ug, eval_usrd_questions as uq, eval_usrd_alternatives as ua    WHERE   qset.q_set_id=$qset AND qset.usrd_eval_id=eu.usrd_eval_id AND ug.usrd_eval_id=eu.usrd_eval_id AND ug.q_id=uq.q_id AND ug.alt_id=ua.alt_id    ORDER BY   uq.max_scores desc, ug.alt_id,ug.q_id");
													  
	   $usrd=mysql_query("SELECT s_ans.q_id,s_ans.scores, count(s_ans.scores) as numstd 	FROM eval_std_answers as s_ans,eval_check_c as chc 	WHERE chc.courses_id=$courses AND chc.q_set_id=$qset AND s_ans.check_c_id =chc.check_c_id   GROUP BY  s_ans.scores desc, s_ans.q_id;");
												
		$num_usrd = array(); 
		
		while ($row2=mysql_fetch_array($usrd))
		{
			array_push($num_usrd,$row2);
		}
		 //print_r($num_usrd); exit();

		if(@mysql_num_rows($selusrd)>=1)
		{    			// START  IF   eval_usrd_details 
  ?>
<table background="images/left_bg.gif" width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="<? echo $top.$left.$right.$bottom; ?>">
  <tr> 
    <td colspan="7" style="<? echo  $bottom; ?>"><br>&nbsp; &nbsp; &nbsp; &nbsp; 
	<? echo $navyO; ?>คำถามจากผู้สอน<? echo $navyC; ?><div align="right"><b>หน่วย : คน</b>&nbsp; </div></td>
  </tr>
  <tr align="center" bgcolor="#E9E9F3"> 
    <td style="<? echo $right; ?>">&nbsp;<? echo $navyO; ?>ข้อที่<? echo $navyC; ?>&nbsp;</td>
    <td bgcolor="#E9E9F3" style="<? echo $right; ?>">&nbsp;<? echo $navyO; ?>คำถาม<? echo $navyC; ?>&nbsp;</td>
    <td height="21" colspan="5">&nbsp;<? echo $navyO; ?>ระดับการประเมิน(คะแนน)<? echo $navyC; ?>&nbsp;</td>
  </tr>
  <?    
		 $cnt2=0; $c2=0; $alt_txt2="";  $a_std2=array(0,0,0,0,0);
			while($rowans2=mysql_fetch_array($selusrd))
			{          	$cnt2++;  
						$c2++;
			 if($c2%2==0)
						$bgcolor="#EAEAFF";
			 else 
						$bgcolor="";		  

			 if($alt_txt2!=$rowans2["alt_id"]  && $alt_txt2==""){ 		  $alt_txt2=$rowans2["alt_id"];
  ?>    
  <tr align="center" bgcolor="#E9E9F3"> 
    <td height="21" style="<? echo $right.$bottom; ?>">&nbsp;</td>
    <td align="left" style="<? echo $right.$bottom; ?>">&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans2["alt1"]."(".$rowans2["res1"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans2["alt2"]."(".$rowans2["res2"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans2["alt3"]."(".$rowans2["res3"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans2["alt4"]."(".$rowans2["res4"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$bottom; ?>"><? echo $navyO.$rowans2["alt5"]."(".$rowans2["res5"].")".$navyC; ?>&nbsp;&nbsp;</td>
  </tr>
  <?   
  			}elseif($alt_txt2!=$rowans2["alt_id"])
  						{  
 ?>
  <tr align="center"> 
    <td height="21" colspan="2"  style="<? echo $top.$right; ?>" align="right"><b>รวม</b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><? echo $a_std2[0]; $a_std2[0]=0;  ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  echo $a_std2[1]; $a_std2[1]=0; ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  echo $a_std2[2];  $a_std2[2]=0; ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  echo $a_std2[3]; $a_std2[3]=0;  ?></b>&nbsp;</td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $top; ?>"><b><?  echo $a_std2[4]; $a_std2[4]=0; ?></b>&nbsp;</td>
  </tr>
  <tr align="center" bgcolor="#E9E9F3"> 
    <td height="21" style="<? echo $top.$bottom; ?>">&nbsp;</td>
    <td align="left" style="<? echo $top.$right.$bottom; ?>">&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans2["alt1"]."(".$rowans2["res1"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans2["alt2"]."(".$rowans2["res2"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans2["alt3"]."(".$rowans2["res3"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$right.$bottom; ?>"><? echo $navyO.$rowans2["alt4"]."(".$rowans2["res4"].")".$navyC; ?>&nbsp;&nbsp;</td>
    <td style="<? echo $top.$bottom; ?>"><? echo $navyO.$rowans2["alt5"]."(".$rowans2["res5"].")".$navyC; ?>&nbsp;&nbsp;</td>
  </tr>
  <?	
				  }           //  END ELSE IF
   ?>
  <tr align="center"> 
    <td bgcolor="<? echo $bgcolor; ?>" height="21" style="<? echo $right; ?>">&nbsp;<? echo $cnt2; ?></td>
    <td bgcolor="<? echo $bgcolor; ?>" align="left" style="<? echo $right; ?>">&nbsp; 
      <? echo $rowans2["question"]; ?></td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $right; ?>">
      <?
	  		$tmp2= Get_Value_from_array2($rowans2["q_id"],$rowans2["res1"],$num_usrd,'q_id','scores','numstd');
	  		$a_std2[0]+=$tmp2;
			echo $tmp2;
	  ?>&nbsp; 
    </td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $right; ?>">
      <? 
	  		$tmp2= Get_Value_from_array2($rowans2["q_id"],$rowans2["res2"],$num_usrd,'q_id','scores','numstd');
	  		$a_std2[1]+=$tmp2;
			echo $tmp2;
	 ?>&nbsp; 
    </td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $right; ?>">
      <? 
	  		$tmp2= Get_Value_from_array2($rowans2["q_id"],$rowans2["res3"],$num_usrd,'q_id','scores','numstd');
	  		$a_std2[2]+=$tmp2;
			echo $tmp2;
	 ?>&nbsp; 
    </td>
    <td bgcolor="<? echo $bgcolor; ?>" style="<? echo $right; ?>">
      <? 
	  		$tmp2= Get_Value_from_array2($rowans2["q_id"],$rowans2["res4"],$num_usrd,'q_id','scores','numstd');
	  		$a_std2[3]+=$tmp2;
			echo $tmp2;
	  ?>&nbsp; 
    </td>
    <td bgcolor="<? echo $bgcolor; ?>">
      <? 
	  		$tmp2= Get_Value_from_array2($rowans2["q_id"],$rowans2["res5"],$num_usrd,'q_id','scores','numstd');
	  		$a_std2[4]+=$tmp2;
			echo $tmp2;
	  ?>&nbsp; 
    </td>
  </tr>
  <? 			}  // END WHILE         ?>
  <tr align="center"> 
    <td height="21" colspan="2"  style="<? echo $top.$right; ?>" align="right"><b>รวม</b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><? echo $a_std2[0]; $a_std2[0]=0;  ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  echo $a_std2[1]; $a_std2[1]=0; ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  echo $a_std2[2];  $a_std2[2]=0; ?></b>&nbsp;</td>
    <td  style="<? echo $top.$right; ?>"><b><?  echo $a_std2[3]; $a_std2[3]=0;  ?></b>&nbsp;</td>
    <td  style="<? echo $top; ?>"><b><?  echo $a_std2[4]; $a_std2[4]=0; ?></b>&nbsp;</td>
  </tr>
  <?   
 	    $usrd_q0=mysql_query("SELECT uq.* FROM eval_q_set as qset,eval_usrd_questions as uq,
													eval_usrd_group as ug
											WHERE  qset.q_set_id=$qset AND qset.usrd_eval_id=ug.usrd_eval_id  AND 
													ug.q_id=uq.q_id AND ug.alt_id=0 AND uq.max_scores=0
											ORDER BY ug.q_id");
		
		 while($rowq=mysql_fetch_array($usrd_q0))
		 {      $cnt2++;
  ?>  
  <tr>
  	<td height="21" style="<? echo $top.$right; ?>" align="center"><? echo $cnt2; ?></td>
  	<td style="<? echo $top.$right; ?>" align="left"><? echo $rowq["question"]; ?></td>
  	<td colspan="5" style="<? echo $top; ?>" align="left"><? 
	$usrd_ans0=mysql_query("SELECT DISTINCT text_ans	FROM eval_usrd_answers WHERE  q_set_id=$qset AND scores=0 ORDER BY q_id");
	$c_utxt=0;
			 while($row_utxt0=mysql_fetch_array($usrd_ans0))
			 {	    $c_utxt++;
			 		if($c_utxt==1){ $br="&nbsp;"; }else{ $br="<br>&nbsp;"; }
			 		echo "$br<img src=\"./images/bullet.gif\" width=\"11\" height=\"11\">  ".$row_utxt0["text_ans"]; 
			 }	?>&nbsp;</td>
  </tr>
  <? 			}   // END while  ?>
</table><br>&nbsp;
<?    }        //  END IF eval_usrd_details 


		 
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
<br><center><input type="button" name="Button" value="Back" onClick="javascript: history.back();">
<!--
<?

     if($courses==null || $courses=='' || $courses==0)
     {  
		          ?><input type="button" name="Button" value="M a i n    m e n u" onClick="javascript: window.location='index.php'"><?
      }else{
		          ?><input type="button" name="Button" value="M a i n    m e n u" onClick="javascript: window.location='cindex.php?courses=<? echo $courses; ?>'"><? 
               } 
?>
-->
</center><br> 
</body>
</html>