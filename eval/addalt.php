<? 
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
		session_start();

$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);

if(isset($_POST[AltSubmit])){  ////ADD  ALTERNATIVE

		for($i=1;$i<=$_POST[num_alt];$i++){
						for($z=1;$z<=5;$z++){
									$alt[$z] = $_POST["alt".$z."_".$i];
									 $res[$z] = $_POST["res".$z."_".$i];
						}
						
						//if($alt[1] !="" && $alt[2]  !="" && $alt[3] !="" &&  $alt[4] !="" &&  $alt[5] !="" && $res[1] !="" &&  $res[2] !="" && $res[3] !="" && $res[4] !="" && $res[5] !="" ){
							$evaluate->Insert_Alt($evaluate,$alt[1],$alt[2],$alt[3],$alt[4],$alt[5],$res[1],$res[2],$res[3],$res[4],$res[5]);
						//}
		}
    		header("Location: addChoice.php");
}
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'addalt.html',
														'header'=>'tea_menu.html',                                           
														
										));   
										
$num = $_GET[alt];

	for($i=1;$i<=$num;$i++){
					$template->assign_block_vars('listalt', array(
																		'NUM'=>$i ,
															));

	}
				$template->assign_vars(array('ALT_ALL'=>$num,
																'NUM_C'=>$_REQUEST[num_C],
																'HOME'=>$HOME_Link,
																'RES_Everage'=>$RES_Everage,
																'RES_Person'=>$RES_Person,
																'Check_no_Eval'=>$Check_no_Eval,
																'THEME_NAME'=>$theme,
																'NO'=>$Eval_StdNum,
																'CHOICE_1'=>$CHOICE_1,
																'CHOICE_2'=>$CHOICE_2,
																'CHOICE_3'=>$CHOICE_3,
																'CHOICE_4'=>$CHOICE_4,
																'CHOICE_5'=>$CHOICE_5,
																'POINTS'=>$POINTS,
																'EXAMPLE'=>$EXAMPLE,
																'ScrLevel'=>$Eval_Score,
													));

										
										
$template->assign_var_from_handle('HEADER','header');
$template->pparse('body');							

	?>