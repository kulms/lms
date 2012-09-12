<?

	if($vraw_score=="on"){$vraw_score=1;}else{$vraw_score=0;}
	
	if($g_active=="on"){
		
		$g_active=1;
		
		if($vgrade_all=="on"){$g_active=2;}
		
		}else{
			
			$g_active=0;
			
			}
		mysql_query("UPDATE g_grade SET
									g_grade_active = ".$g_active.",
									g_view_raw = ".$vraw_score.",
									g_lastupdate = ".time()."
									WHERE g_courses=".$g_courses." and g_users=".$person["id"].";");		
/* echo "<script language='javascript'>alert('Update success');location.href='index.php?a=prefs';</script>";*/

	echo "<script language='javascript'>alert('Update success');window.close();</script>";
?>