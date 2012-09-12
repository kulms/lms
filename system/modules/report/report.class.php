<?
require_once("DB.php");

class Report {
	var $cat_id = NULL;

	function getCatId() {
		return $this->cat_id;
	}

	function Report($cat_id) { 
		$this->cat_id = $cat_id;
	}
	function SelectTimeDB()
	{
		global $dsn;
			// Get Connection
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT MAX(time) as time FROM report ORDER BY time DESC";
		$result = $db->query($sql);	
		while ($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$time = $rs["time"];
		}
	return $time;
	}
	function RefreshDB($Time)
	{
		global $dsn;
			// Get Connection
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
			}
		$sql="SELECT * FROM login WHERE time > $Time";
		$result = $db->query($sql);
		if($result->numRows() !=0){
			while ($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$user = $rs["users"];
				$time = $rs["time"];
				$action_id = $rs["action_id"];
				Report::CreateReport($user,0,0,0,0,$time,$action_id,0,'');
			}
		}
		Report::DeleteData($Time,'login');
		$sql1="SELECT * FROM modules_history WHERE time > $Time";
		$result1= $db->query($sql1);
		if($result1->numRows() !=0){
			while ($rs1 = @$result1->fetchRow(DB_FETCHMODE_ASSOC)) {
				$user = $rs1["user"];
				$time = $rs1["time"];
				$action_id = $rs1["action_id"];
				$modules_id=$rs1["modules_id"];
				$group_id=$rs1["group_id"];
				$folder_id=$rs1["folder_id"];
				$courses_id=$rs1["courses_id"];
				$courses=$rs1["courses"];
				$name=$rs1["name"];
				Report::CreateReport($user,$modules_id,$group_id,$folder_id,$courses_id,$time,$action_id,$courses,$name);
			}
		}
		Report::DeleteData($Time,'modules_history');
	}

	function DeleteData($time,$tb)
	{
		global $dsn;
			// Get Connection
			$db = DB::connect($dsn);
			if( DB::isError($db) ) {
			   die ($db->getMessage());
		}
		$Time=date("d-m-Y H:i",$time);
		$date_parts = explode("-",$Time);
             if($date_parts[2]<1990)
                 { 
						$years=1900+$date_parts[2];
                 }else{
                      $years=$date_parts[2];
	             }
			$Time1=mktime(0,0,0,$date_parts[1]-1,$date_parts[0],$years);
			$sql="DELETE FROM ".$tb." WHERE time< $Time1";
			$result = $db->query($sql);
				if( DB::isError($result) ) {
				  die ($result->getMessage());
				  return false;
				}
				return true;	   	
	}

	function CreateReport($user,$modules_id,$group_id,$folder_id,$courses_id,$time,$action_id,$courses,$name)
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		 $sql="INSERT INTO report (user,modules_id,group_id,folder_id,courses_id,time,action_id,courses,name) VALUES ($user,$modules_id,$group_id,$folder_id,$courses_id,$time,$action_id,$courses,'".$name."')";
		$result = $db->query($sql);
				if( DB::isError($result) ) {
		  die ($result->getMessage());
		  return false;
		}
		return true;	   	
	}

	function SelectReportAll($user,$filter,$order,$courses,$BTime,$ETime,$action,$user_type)
	{
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		//$sql="SELECT admin 
		//			FROM users 
		//			WHERE id=$user";
	//	$data_sql=mysql_query($sql);
	//	$admin=mysql_result($data_sql,0,"admin");
		if($filter=='time')
		{
			//Begin Time
			$date_parts = explode("-",$BTime);
             if($date_parts[2]<1990)
                 { 
						$years=1900+$date_parts[2];
                 }else{
                      $years=$date_parts[2];
	             }
			$BTime=mktime(0,0,0,$date_parts[1],$date_parts[0],$years);
			//End Time
			$date_parts = explode("-",$ETime);
             if($date_parts[2]<1990)
                 { 
						$years=1900+$date_parts[2];
                 }else{
                      $years=$date_parts[2];
	             }
			$ETime=mktime(0,0,0,$date_parts[1],$date_parts[0]+1,$years);
			
		}
		if($courses != ""){
			$where=" AND (r.modules_id !=0 OR r.group_id !=0 OR r.folder_id !=0 OR r.courses_id !=0) AND courses=$courses";
		}
		if($user_type ==0 || $user_type=="")
			$user_cat="";
		else
			$user_cat=" AND u.category=$user_type";
			switch ($action){
				case ("all"):
					if($filter=='time')
						$where="WHERE (r.time>=$BTime AND r.time <$ETime) AND u.id=r.user".$user_cat.$where;
					else
						$where="WHERE u.id=r.user".$user_cat.$where;
				break;
				case ("courses"):
					switch ($filter){
						case (""):
							$where="WHERE u.id=r.user AND r.courses_id !=0".$user_cat.$where;
						break;
						case ("time"):
							$where="WHERE (r.time>=$BTime AND r.time <$ETime) AND u.id=r.user AND r.courses_id !=0 ".$user_cat.$where;
						break;
						case ("create"):
							$where=",action a WHERE u.id=r.user AND r.courses_id !=0 AND a.action='Create Courses' AND a.id=r.action_id ".$user_cat.$where;
						break;
						case ("update"):
							$where=",action a WHERE u.id=r.user AND r.courses_id !=0 AND a.action='Update courses' AND a.id=r.action_id ".$user_cat.$where;
						break;
						case ("delete"):
							$where=",action a WHERE u.id=r.user AND r.courses_id !=0 AND a.action='Delete courses' AND a.id=r.action_id ".$user_cat.$where;
						break;
						case ("apply"):
							$where=",action a WHERE u.id=r.user AND r.courses_id !=0 AND a.action='Apply courses' AND a.id=r.action_id ".$user_cat.$where;
						break;
						case ("drop"):
							$where=",action a WHERE u.id=r.user AND r.courses_id !=0 AND a.action='Drop courses' AND a.id=r.action_id ".$user_cat.$where;
						break;
					}
				break;
				case("login"):
					if($filter=='time')
						$where=",action a WHERE (r.time>=$BTime AND r.time <$ETime) AND a.action='Login' AND u.id=r.user AND a.id=r.action_id".$user_cat;
					else
						$where=",action a WHERE u.id=r.user AND a.action='Login' AND a.id=r.action_id".$user_cat;
				break;
				case("logout"):
					if($filter=='time')
						$where=",action a WHERE (r.time>=$BTime AND r.time <$ETime) AND a.action='Logout' AND u.id=r.user AND a.id=r.action_id".$user_cat;
					else
						$where=",action a WHERE u.id=r.user AND a.action='Logout' AND a.id=r.action_id".$user_cat;
				break;
				case("modules"):
					switch ($filter){
						case (""):
							$where="WHERE u.id=r.user AND (r.folder_id !=0 OR r.group_id !=0 OR r.modules_id !=0)".$user_cat.$where;
						break;
						case ("time"):
							$where="WHERE (r.time>=$BTime AND r.time <$ETime) AND u.id=r.user AND  (r.folder_id !=0 OR r.group_id !=0 OR r.modules_id !=0) ".$user_cat.$where;
						break;
						case ("folder"):
							$where=" WHERE u.id=r.user AND r.folder_id !=0 ".$user_cat.$where;
						break;
						case ("group"):
							$where=" WHERE u.id=r.user AND r.group_id !=0 ".$user_cat.$where;
						break;
						case ("forum"):
							$where=",action a WHERE u.id=r.user AND r.modules_id !=0 AND a.modules_type=1 AND a.id=r.action_id ".$user_cat.$where;
						break;
						case ("webboard"):
							$where=",action a WHERE u.id=r.user AND r.modules_id !=0 AND a.modules_type=4 AND a.id=r.action_id ".$user_cat.$where;
						break;
						case ("resources"):
							$where=",action a WHERE u.id=r.user AND r.modules_id !=0 AND a.modules_type=3 AND a.id=r.action_id ".$user_cat.$where;
						break;
						case ("quiz"):
							$where=",action a WHERE u.id=r.user AND r.modules_id !=0 AND a.modules_type=5 AND a.id=r.action_id ".$user_cat.$where;
						break;
						case ("hw"):
							$where=",action a WHERE u.id=r.user AND r.modules_id !=0 AND a.modules_type=7 AND a.id=r.action_id ".$user_cat.$where;
						break;
					}
				break;
				break;
		}
			$sql="SELECT r.* FROM report r,users u ".$where." ORDER BY $order";
		//	echo $sql;
			$result = $db->query($sql);
			if($user =="")
				return $result;
			else
				return $sql;
	}

	function SelectUsersPerPage($sql,$page) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		if( DB::isError($db) ) {
		   die ($db->getMessage());
		}
		$pagesize=50;
		$maxRow = $page*$pagesize;
		if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}
		$numRow = " LIMIT ".$start.", ".$pagesize;
		$sql=$sql.$numRow;
		$result = $db->query($sql);
	
		return $result;
	
	}	

	function  ShowTableAll($result,$order) {
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		//$result = $db->query($sql);
if($result->numRows() !=0){
	echo "<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	while ($rs = @$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$user=$rs["user"];
		$time=$rs['time'];
		$action_id=$rs['action_id'];
		$modules_id =$rs['modules_id'];
		$group_id=$rs['group_id'];
		$folder_id=$rs['folder_id'];
		$courses_id=$rs['courses_id'];
		$name=$rs['name'];
		$Time=date("d-m-Y H:i",$time);
		$courses=$rs['courses'];
		//LoginName
			$sql=mysql_query("SELECT login FROM users WHERE id=$user");
			$LoginName=mysql_result($sql,0,"login");
		
		//Action
			$sql=mysql_query("SELECT action FROM action WHERE id=$action_id");
			$Action=mysql_result($sql,0,"action");
		
		//Courses

			if($courses !=0){
				$sql=mysql_query("SELECT name  FROM courses  WHERE id =$courses");
				@$cname=mysql_result($sql,0,"name");
				$C_Name=$cname;
			}else
				$C_Name="-";
			
			//Modules
			if($modules_id !=0 or $group_id !=0 or $folder_id !=0 ){
				if($modules_id !=0){
					//$sql=mysql_query("SELECT name  FROM modules_history  WHERE modules_id =$modules_id");
					$M_Name=$name;
				}
				if($group_id !=0){
				//	$sql=mysql_query("SELECT name  FROM modules_history  WHERE group_id =$group_id");
					$M_Name=$name;
				}
				if($folder_id !=0){
				//	$sql=mysql_query("SELECT name  FROM modules_history  WHERE folder_id =$folder_id");
					$M_Name=$name;
				}
			}else{
				$M_Name="-";
			}
					echo "<tr>";
					echo "<td width=\"23%\">$Time</td>";
					echo "<td width=\"29%\">$LoginName</td>";
					echo "<td width=\"16%\">$Action</td>";
					echo "<td width=\"16%\">$M_Name</td>";
					echo "<td width=\"16%\">$C_Name</td>";
					echo "</tr>";
    	}
					echo "</table>";
}else{
		echo "<table>";
		echo "<tr>";
		echo "<td colspan=\"5\">No Data</td>";
		echo "</tr>";
		echo "</table>";
}	
}

function ShowSeqTable($sql,$page,$action,$filter,$btime,$etime,$order,$courses,$user_type){
		global $dsn;
		// Get Connection
		$db = DB::connect($dsn);
		$result = $db->query($sql);
		$num = $result->numRows();	
		$pagesize=50;
		$page_amnt_per_page_range = 10;   //กำหนดจำนวนหมายเลขหน้าที่จะแสดงต่อหน้า
		if (empty($start)) { //ลองตรวจดูว่าค่าแถวเริ่มต้นที่จะแสดงไม่ได้กำหนดหรือเปล่า ถ้าไม่ได้กำหนด จะกำหนดให้เป็น 0 
		  $start = 0; 
		} 

		//$totalpage = intval((($num-1)/$pagesize)+1); //หาค่าจำนวนหน้าทั้งหมดที่ต้องแสดง 
		
		$totalpage =(int)($num/$pagesize);
		
		if (($num % $pagesize) != 0)
				{
						$totalpage += 1;
				}

			if (isset($page)){
						$start = $pagesize * ($page -1);
			}else{
						$page =1;
						$start=0;
			}	
			//echo $start; 	
			 $current_page = (($start)/$pagesize)+1; //หาว่าหน้าที่แสดงอยู่ปัจจุบันเป็นหน้าที่เท่าไหร่ 
		  // table แสดงเลขหน้า
		 echo "<SCRIPT LANGUAGE=\"JavaScript\">";
		 echo "function page(a,f,bt,et,p,o,c,ut,s){";
		 echo "window.location=\"?m=report&a=\"+a+\"&filter=\"+f+\"&beTime=\"+bt+\"&endTime=\"+et+\"&page=\"+p+\"&order=\"+o+\"&courses=\"+c+\"&user_type=\"+ut+\"&start=\"+s+\" \" ";
		 echo "}";
		 echo "</SCRIPT>";
		  if($num !=0){
		echo "<table width=100% border=0 bordercolor=black cellspacing=0 cellpadding=2>\n";
		echo "<tr><td align=left>\n";
		echo "\t<font size=2 >\n";

		// สร้าง link เพื่อไปหน้าก่อน-หน้าถัดไป
		if($page>1 && $page<=$totalpage) {
				//echo "d"."<br>";
				$prevpage = $page-1;
				echo "\t<a href=\"Javascript:page('$action','$filter','$btime','$etime','$prevpage','$order','$courses','$user_type','');\" ><img src=\"../images/back.gif\" border=\"0\" align=\"top\"></a>\n";
		}

		echo "\t [$page/$totalpage] \n";

		if($page!=$totalpage) {
				$nextpage = $page+1;
				echo "\t<a href=\"Javascript:page('$action','$filter','$btime','$etime','$nextpage','$order','$courses','$user_type','');\" ><img src=\"../images/next_.gif\" border=\"0\" align=\"top\"></a>\n";
		}

		echo "\t</font>\n";
		echo "</td></tr>\n";
		echo "<tr><td>\n";

/*
		// วนลูปแสดงเลขหน้าทั้งหมด
		for($i=1 ; $i<$page ; $i++) {
				echo "\t<a href=\"Javascript:page('$action','$filter','$btime','$etime','$i','$order','$courses','$user_type');\">$i</a> \n";
		}
		echo "\t<font size=2 color=red><b>$page</b></font> \n";
		for($i=$page+1 ; $i<=$totalpage ; $i++) {
				echo "\t<a href=\"Javascript:page('$action','$filter','$btime','$etime','$i','$order','$courses','$user_type');\" >$i</a> \n";
		}
*/
if ($totalpage>1) { //ตรวจดูว่าถ้าจำนวนหน้าทั้งหมดมีเกิน 1 หน้า ต้องแสดงบรรทัดที่จะให้เลือกหน้า 
  $begin_page_range = (intval(($page - 1)/$page_amnt_per_page_range) * $page_amnt_per_page_range) +1;
  $previous_page_range = $begin_page_range - 2; //หาว่าช่วงหน้าก่อนหน้าปัจจุบันคือหน้าอะไร 
  $next_page_range = $begin_page_range + $page_amnt_per_page_range - 1; //หาว่าช่วงหน้าถัดจากหน้าปัจจุบันคืออะไร 
  if ($previous_page_range >0) { //ถ้าช่วงหน้าก่อนหน้าติดลบหรือเป็นศูนย์แสดงว่าไม่สามารถแสดงช่วงหน้าก่อนหน้าได้ 
    $new_startrow = ($begin_page_range - 2) * $pagesize; 
	$prev_page=$begin_page_range-$page_amnt_per_page_range;
  //  $left_page_show = "<A HREF=$PHP_SELF?start=$new_startrow>&lt;&lt;</A> " ; 
	$left_page_show ="<a href=\"Javascript:page('$action','$filter','$btime','$etime','$prev_page','$order','$courses','$user_type');\" > &lt;&lt;</a>";
  } else { 
    $left_page_show = "  "; 
  } 
  if ($next_page_range > $totalpage) { //ถ้าช่วงหน้าถัดไป มากกว่าจำนวนหน้าทั้งหมด แสดงว่าไม่สามารถแสดงหน้าถัดไปได้ 
    $right_page_show = " "; 
  } else { 
	$new_startrow = ($begin_page_range + $page_amnt_per_page_range - 1)*$pagesize; 
	$next_page=$begin_page_range+$page_amnt_per_page_range;
  //  $right_page_show = " <A HREF=$PHP_SELF?start=$new_startrow>&gt;&gt;</A>"; 
 $right_page_show ="<a href=\"Javascript:page('$action','$filter','$btime','$etime','$next_page','$order','$courses','$user_type');\" > &gt;&gt;</a>";
  } 
  $middle_page_show = ""; 
  
  for ($i=$begin_page_range;($i<=$totalpage) AND ($i<$begin_page_range+$page_amnt_per_page_range);$i++) { //วนลูปแสดงหน้าทั้งหมด 
    if ($i == $page) { //ถ้าหน้าที่พิมพ์เป็นหน้าเดียวกับหน้าปัจจุบัน แสดงให้ไม่สามารถคลิ๊กได้ 
      $middle_page_show .= " <font size=2 color=red><b>$i</b></font> "; 
    } else { 
      $new_startrow = (($i-1)*$pagesize); 
     // $middle_page_show .= " <A HREF=$PHP_SELF?start=$new_startrow>$i</A> "; 
	 $middle_page_show .=" <a href=\"Javascript:page('$action','$filter','$btime','$etime','$i','$order','$courses','$user_type','$new_startrow');\">$i</a>";
    } 
  } 
  $page_show = $left_page_show . $middle_page_show . $right_page_show; 
} else { 
  $page_show = ""; 
} 
		echo $page_show; 
		echo "</td></tr>\n";
		echo "</table>\n";
	}
	}

} // end class
?>