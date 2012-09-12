<? 
include('config.inc.php');
require("../eval/include/eval.class.php");
$template= new Template(C_SKIN);
$template->set_filenames(array('body' =>'test.html',
//													'header'=>'tea_menu.html',                                            
									));   
$template->pparse('body');

echo C_SKIN;
echo "<img src=\"../eval/images/eval_clock.gif\" width=\"78\" height=\"95\">";
echo "sss";
?>