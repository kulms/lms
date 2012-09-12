<?  
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
		session_start();
//echo "name==".$_SESSION[g_name];                  echo "id==".$_SESSION[g_id];

$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);

//START  INSERT Question
if(isset($_POST[AddQ])){
		if($_SESSION[g_id] != ""){
					$gp_id = $_SESSION[g_id] ;
		}else{
				$gp_id = $evaluate->AddGroupQ($evaluate,$_SESSION[g_name],$_SESSION[module_id]);
		}
	
// add  Choice
	for($i=1;$i<=$_SESSION[num_C];$i++){
				$cat_id=1;
				if($_POST["q".$i] !=""){
					if($_POST["active_c".$i] =="")  $active =0;
							else $active = $_POST["active_c".$i] ;
							//echo $active ;
							$evaluate->InsertQuestion($evaluate,'',$_POST["alt".$i],$gp_id,$_POST["q".$i],$cat_id,0,0,$active);
			    }
		}
		
// add Fill Question
		for($i=1;$i<=$_SESSION[num_F];$i++){
					$cat_id2=2;
					if($_POST["text".$i] !=""){
						if($_POST["active_f".$i] =="")  $active =0;
								else  $active = $_POST["active_f".$i] ;
								$evaluate->InsertQuestion($evaluate,'',0,$gp_id,$_POST["text".$i],$cat_id2,0,0,$active);
					}
		}
 header("Location: t_index.php?grp_id=$gp_id#QT");
}// END     INSERT Question




 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'addChoice.html',
														'header'=>'tea_menu.html',                                           
										));   
										

if($_SESSION[num_C] > 0){
			$template->assign_block_vars('startB1',''  );
}
for($i=1;$i<=$_SESSION[num_C];$i++){
			$template->assign_block_vars('startB1.boxQ', array(
																	'NUM'=>$i ,
																	'ALT'=>$evaluate->GetAltStd($evaluate,'') ,
															));
		}
		
//num_F
if($_SESSION[num_F] > 0){
			$template->assign_block_vars('startB2',''  );
}
		for($i=1;$i<=$_SESSION[num_F];$i++){
					$template->assign_block_vars('startB2.boxQF', array(
																			'NUM'=>$i ,
															));
		}


$template->assign_vars(array('NUM_C'=>$num_C,
														'GNAME'=>$_SESSION[g_name],
														'GID'=>$_SESSION[g_id],
														'CNAME'=>$evaluate->getCourseName($_SESSION[course]),
														'THEME_NAME'=>$theme,
														'ChoiceQues'=>$ChoiceQues,
														'FillQues'=>$FillQues,
														'Eval_Num'=>$Eval_Num,
														'Eval_Question'=>$Eval_Question,
														'ALTERNATIVE'=>$ALTERNATIVE,
														'choice'=>$choice,
														'FullCharacters'=>$FullCharacters,
														'ADDALT'=>$AddAlt,
														'Create'=>$strCreate,
														'Back'=>$strBack,
														'HOME'=>$HOME_Link,
														'RES_Everage'=>$RES_Everage,
														'RES_Person'=>$RES_Person,
														'Check_no_Eval'=>$Check_no_Eval,
											));

										
										
$template->assign_var_from_handle('HEADER','header');
$template->pparse('body');							

	?>