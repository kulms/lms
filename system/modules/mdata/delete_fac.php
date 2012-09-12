<?php  	 		
		//session_start();		
				
		// delete Faculty
		mysql_query("delete from ku_faculty where id=$id;"); 
			
		// select Department		
		$result=mysql_query("SELECT * FROM ku_department dd WHERE dd.FAC_ID=$id;");
		$deptID="";
		
		//delete student in task
		if($row =mysql_fetch_array($result))
		{	$deptID.= "DEPT_ID = ".$row["id"];	
			while($row=mysql_fetch_array($result))		
			  $deptID.= " or DEPT_ID = ".$row["id"];	
		}
		
		mysql_query("delete from ku_department where FAC_ID=$id");
		if($deptID!="")
		{
			mysql_query("delete from ku_major where $deptID");
		}
	print("<script language='javascript'>document.write('Completely Delete! ');document.location='./index.php?m=mdata&a=insert_fac&id=$dept_id';</script>"); 
?>		
