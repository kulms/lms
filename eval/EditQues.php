<?  
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
		session_start();
		
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);

///******************************UPDATE********************************************************
if($_GET[upchoice]==1){
		if($_POST[active_c] =="")  $active =0;
				else $active=$_POST[active_c];
		 $evaluate->updateQuestion($_POST[q_id],$_POST[newalt],$_POST[newChoice],1,0,$active);
			 			echo "<script language=\"javascript\"> ";
				  		 echo "window.opener.location.href=\"t_index.php?grp_id={$_REQUEST[grp_id]}\";";
  						 echo "window.close();";
						echo "</script>";
						
}else if($_GET[upFill]==1){
						//echo $_POST[q_id]."alt==".$_POST[newalt]."QQ==".$_POST[newFillQ]."act==".$_POST[active_f];
					if($_POST[active_f] =="")  $active =0;
							else  $active= $_POST[active_f];
 	 $evaluate->updateQuestion($_POST[q_id],0,$_POST[newFillQ],2,0,$active);
 						echo "<script language=\"javascript\"> ";
				  		 echo "window.opener.location.href=\"t_index.php?grp_id={$_REQUEST[grp_id]}\";";
  						 echo "window.close();";
						echo "</script>";

}else if($new_gname !=""){
						//echo $grp_id ,$new_gname;
 	 $evaluate->updateGroup($grp_id,$new_gname);
 						echo "<script language=\"javascript\"> ";
				  		 echo "window.opener.location.href=\"t_index.php?grp_id={$_REQUEST[grp_id]}\";";
  						 echo "window.close();";
						echo "</script>";

}
///******************************UPDATE********************************************************



$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'EditQues.html',
										));  
										
										
if($_GET[q_id] !=""){
	@list($q_id,$alt_id,$users_id,$g_id,$question,$cat_id,$std_q,,$active) = $evaluate->GetQuestionOne($evaluate,$q_id);

			if($_GET[fill]==1){
					$template->assign_block_vars('startB2', array(
												'NUM'=>$q_id,
												'Question'=>$question,
												'CHECK'=>($active==1)?"checked":"",
												));
			}else{
				//@list($alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5) = $evaluate->GetAltOfQ($evaluate,$alt_id);
			// $Firstalt ="<option value=\"$alt_id\">".$alt1."[".$res1."], ".$alt2."[".$res2."], ".$alt3."[".$res3."], ".$alt4."[".$res4."], ".$alt5."[".$res5."]</option>";           
							$template->assign_block_vars('startB1', array(
									'NUM'=>$q_id,
									'FIRSTALT'=>$Firstalt,
									'Question'=>$question,
									'ALT'=>$evaluate->GetAltStd($evaluate,$alt_id),
									'CHECK'=>($active==1)?"checked":"",
									));

			}

		$template->assign_vars(array('GID'=>$_REQUEST[grp_id],
																'THEME_NAME'=>$theme,
																'EDIT_QC'=>$EDIT_QC,
																'EDIT_QF'=>$EDIT_QF,
																'ALTERNATIVE'=>$ALTERNATIVE,
																'Eval_Question'=>$Eval_Question,
													));
}

 if($_GET[gname] !=""){
				$template->assign_block_vars('startG1', array('OLDNAME'=>$gname,
																						'GID'=>$grp_id,
																		));
				$template->assign_vars(array('THEME_NAME'=>$theme,
																	'EDIT_GROUP'=>$EDIT_GROUP,
																	'NEW_GROUPNAME'=>$NEW_GROUPNAME, 
													));

}

$template->pparse('body');							
?>