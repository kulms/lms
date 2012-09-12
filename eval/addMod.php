<?
	    include("../include/global_login.php");
		include("./include/var.inc.php");

	if($modules){
			$end_date=$_POST["end_date"]." 23:59:59";
			$start_date=$_POST["start_date"]." 00:00:01";
			$semester=$_POST["semester"];
			$year=$_POST["year"];
			$info =$_POST["info"];
			$show_std =$_POST["show_std"];
			
			if($show_std=="" || $show_std==null){ $show_std=0; }else{ $show_std=1; }
			$sqlm="SELECT courses FROM modules WHERE id ='$modules'";
			$rs = mysql_fetch_array(mysql_query($sqlm));				
			$courses = $rs[0];
			
if(isset($update)){

			$sql="UPDATE eval_q_set  
						SET eval_type='$eval_type',
						info='$info',
						semester='$semester',
						year=$year, 
						end_date='$end_date', 
						start_date='$start_date',
						show_std='$show_std',
						show_rs='$std_show'
						 WHERE modules_id ='$modules' ";
			$rs = mysql_query($sql);				

			if($eval_name){
					$sql_m="UPDATE modules
									SET name='$eval_name',
									updated = ".time()."
									 WHERE id ='$modules' ";
					$rs_m = mysql_query($sql_m);				
			}
			
}else if(isset($delete)){

			$delm= "DELETE FROM modules  WHERE id='$modules' ";
			$delmr = mysql_query($delm);   
			$sql = "DELETE FROM eval_q_set  WHERE modules_id ='$modules' ";
			$rs = mysql_query($sql);
			$sql2= "DELETE FROM eval_usrd_answers   WHERE  modules_id ='$modules' ";
			$rs2 = mysql_query($sql2);
			$eg = "SELECT * FROM  eval_usrd_group
						WHERE modules_id = '$modules'  ";
						$egr = mysql_query($eg);
						 while($arr=mysql_fetch_array($egr)){
								 $delq = "DELETE FROM eval_usrd_questions
													WHERE g_id = '$arr[g_id]' ";
									$delqr = mysql_query($delq);
									
								}
			$delg ="DELETE FROM  eval_usrd_group
						WHERE modules_id = '$modules'  ";
			$delgr = mysql_query($delg);

}else if(isset($create)){
//echo  $std_show;  break;
	$sqlC="INSERT INTO eval_q_set (modules_id,eval_type,info,courses_id,semester,year,start_date,end_date,show_std,show_rs)  
	VALUES ('$modules','$eval_type','$info', '$courses','$semester','$year', '$start_date', '$end_date','$show_std','$std_show');";
	$rsC = mysql_query($sqlC);				
	
}
}  // close of Submit

?>

<script language="javascript">
			function update(){
				top.ws_menu.location.reload();
			}
		</script>
		<body  onLoad="update()">
		<div align="center" class="main">Module created...</div>
		</body> 