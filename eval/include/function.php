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
?>