<?
 	    require("../include/global_login.php");
		
		$selqset="SELECT * FROM eval_q_set as qset WHERE qset.courses_id=$courses AND current=1 AND semester= AND year=;";
		$sel_qset=mysql_query($selqset);
		if(@mysql_num_rows($sel_qset)==0){
			
		}		
?>