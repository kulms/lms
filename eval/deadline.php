<? 
session_start();
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");

//-----------------------------------------Template--------------------------------------------------------------------
 $template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'deadline.html',
										));   
//echo $eval_type; break;
				$template->assign_vars(array('THEME_NAME'=>$theme,
																		'COS'=>$course,
																		'HEAD'=>"Sorry!!!",
																		'DETAIL'=>($eval_type==1)?"ขณะนี้ได้ปิดรับการทำแบบสอบถามแล้ว":"ขณะนี้ได้ปิดรับการทำแบบสำรวจการเรียนรู้  (Perceptual Learning Style Preference Survey ) ของนิสิตแล้ว",
									     ));

$template->pparse('body');							
?>
