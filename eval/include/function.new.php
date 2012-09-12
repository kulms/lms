<?
	function CheckUser($courses,$users)
	{
		$check_users=mysql_query("SELECT distinct  wp.id as wpid, wp.modules as wp_m, wp.admin, wp.courses as wpc FROM wp  WHERE wp.courses=$courses AND wp.admin=1 AND wp.users=$users AND wp.cases=0 AND wp.groups=0 AND wp.folders=0 AND wp.modules=0;");
		// ????????????????? course ??????????
		// echo "SELECT distinct  wp.id as wpid, wp.modules as wp_m, wp.admin, wp.courses as wpc FROM wp  WHERE wp.courses=$courses AND wp.admin=1 AND wp.users=".$person["id"]." AND wp.cases=0 AND wp.groups=0 AND wp.folders=0 AND wp.modules=0<br>";
		$check_users=@mysql_num_rows($check_users);
		return $check_users;
	}
	
	function getQset($courses,$users)
	{
		$res = mysql_query("SELECT qset.q_set_id FROM eval_q_set as qset, wp WHERE wp.users=$users AND wp.courses=$courses AND qset.courses_id=$courses AND wp.courses=qset.courses_id;");
		$qset=@mysql_result($res,0,"q_set_id");		
		// if(mysql_num_rows($res) > 0){ }
		return $qset;
	}
	// ??????????? : getQSetID($courses,$person["id"]);
	
	function getStd($qset){
			$selstd=mysql_query("SELECT count(*) as std FROM eval_check_c as chc WHERE chc.q_set_id=$qset AND chc.status=1");
			// print("SELECT count(*) as std FROM eval_check_c as chc WHERE chc.q_set_id=$qset AND chc.status=1 <br>");
			$std=@mysql_result($selstd,0, "std"); 
			return $std;
	}
	
	function getTotalStd($qset){
			$seltotal=mysql_query("SELECT  count(*) as total FROM eval_check_c as chc WHERE chc.q_set_id=$qset;");
			// print("SELECT  count(*) as total FROM eval_check_c as chc WHERE chc.q_set_id=$qset; <br>");
			$totalstd=@mysql_result($seltotal,0,"total");
			return $totalstd;
	}
	
	function printMenu($lv){
				$menu='<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr> 
			<td height="24" bgcolor="#004080" class="bwhite">&nbsp; ระบบประเมินการสอนของอาจารย์โดยนิสิต ( Teaching 
			  Evaluate System :TES )</td>
		  </tr>
		  <tr> 
			<td height="24" bgcolor="#E9E9F3">  <b><a href="'.$lv.'index.php">Home</a>
			  | <a href="'.$lv.'cindex.php?courses='.$courses.'">วิชา'.getCoursename($courses).'</a><?    
			   
			   $sel_start=mysql_query("SELECT start_date FROM eval_q_set as q_set WHERE q_set.q_set_id=$qset;");
			   $start_date=mysql_result($sel_start,0,"start_date");		
			   $today=date("Y-m-d H:i:s");	
			   
			  if($today<$start_date)
			  {	?>
			  | <a href="<? echo $lv; ?>Add_usrdQ.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">เพิ่มคำถามจากผู้สอน</a> 
			  <? }else{ ?>
			  | <a href="<? echo $lv; ?>cresult.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ผลการประเมินแสดงคะแนนเฉลี่ย</a> 
			  | <a href="<? echo $lv; ?>numstd.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ผลการประเมินแสดงจำนวนผู้ตอบ</a> 
			  <?         }	 if(  ($totalstd-$std)>=1){ ?>
			  | <a href="<? echo $lv; ?>trackstd.php<? echo "?courses=$courses&qset=$qset&std=$std&totalstd=$totalstd"; ?>">ตรวจสอบรายชื่อผู้ที่ยังไม่ได้ประเมิน</a>
			  <? } ?>
			   | <a onClick="MM_openBrWindow(\'<? echo $lv; ?>report/eval_report.htm\',\'\',\'scrollbars=yes,width=800,height=600, resizeable=yes, statusbar=yes\')" style="cursor:hand">ข้อมูลการประเมินย้อนหลัง</a></b> 
			</td>
		  </tr>
		</table>';
		return $menu;
	}
	function getCoursename($c){
			   $sel_cname=mysql_query("SELECT c.* FROM courses as c WHERE c.id=$c;");
			   $coursename=mysql_result($sel_cname,0,"name");
			   return  $coursename;
	}
?>